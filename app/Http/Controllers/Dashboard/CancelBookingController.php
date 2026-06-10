<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancelledMail;
use App\Models\TimeSlot;
use App\Services\GiftVoucherService;
use App\Services\MailTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\MollieApiClient;

class CancelBookingController extends Controller
{
    public function __invoke(Request $request, TimeSlot $timeSlot, GiftVoucherService $voucherService, MailTemplateService $mailTemplateService)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $action = $request->input('action', 'cancel'); // cancel | voucher

        $timeSlot->loadMissing(['room.escaperoomAddress', 'language', 'orderedItems.order.customer']);
        $orderedItem = $timeSlot->orderedItems->first();
        $order       = $orderedItem?->order;

        $voucher = null;

        if ($action === 'voucher' && $order) {
            $voucher = $voucherService->createForCancellation($order);
        }

        $timeSlot->delete(); // soft delete

        // Order die nog niet betaald is: annuleren zodat de bestelling niet meer als
        // "openstaand" wordt getoond en de bijhorende Mollie-betaallink niet meer
        // betaald kan worden.
        if ($order && $order->status === 'pending') {
            if ($order->mollie_id) {
                try {
                    $mollieKey = $escaperoom->escaperoomSetting->mollie_api_key ?? env('MOLLIE_KEY');
                    if ($mollieKey) {
                        $mollie = new MollieApiClient();
                        $mollie->setApiKey($mollieKey);
                        $mollie->salesInvoices->update($order->mollie_id, ['status' => 'canceled']);
                    }
                } catch (\Throwable $e) {
                    Log::warning('Kon Mollie-factuur niet annuleren voor order ' . $order->id . ': ' . $e->getMessage());
                }
            }

            $order->status = 'cancelled';
            $order->save();
        }

        // Annuleringsmail sturen naar de klant: eerst het sjabloon van de escaperoom proberen,
        // anders terugvallen op de ingebouwde mail.
        $customerEmail = $order?->customer?->email ?? $order?->customer_email;
        if ($customerEmail && $order) {
            $sentCustomTemplate = $mailTemplateService->sendForRoomCancellation($timeSlot, $order, $voucher);

            if (! $sentCustomTemplate) {
                Mail::to($customerEmail)->send(
                    new BookingCancelledMail($timeSlot, $order, $escaperoom, $voucher)
                );
            }
        }

        return response()->json([
            'ok'           => true,
            'action'       => $action,
            'voucher_code' => $voucher?->code,
        ]);
    }
}
