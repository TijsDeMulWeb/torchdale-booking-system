<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancelledMail;
use App\Models\TimeSlot;
use App\Services\GiftVoucherService;
use App\Services\MailTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            $cancelledPdfPath = null;

            if ($order->mollie_id) {
                try {
                    $mollieKey = $escaperoom->escaperoomSetting->mollie_api_key ?? env('MOLLIE_KEY');
                    if ($mollieKey) {
                        $mollie = new MollieApiClient();
                        $mollie->setApiKey($mollieKey);
                        $cancelledInvoice = $mollie->salesInvoices->update($order->mollie_id, ['status' => 'cancelled']);

                        $pdfHref = $cancelledInvoice->_links->pdfLink->href ?? null;
                        if ($pdfHref) {
                            $pdfResponse = Http::withToken($mollieKey)->get($pdfHref);
                            if ($pdfResponse->successful()) {
                                $invoiceNumber = $cancelledInvoice->invoiceNumber ?? $order->invoice_number ?? ('INV-' . $order->id);
                                $cancelledPdfPath = 'escaperooms/' . $order->escaperoom_id . '/invoices/' . $invoiceNumber . '.pdf';
                                Storage::disk('local')->put($cancelledPdfPath, $pdfResponse->body());
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning('Kon Mollie-factuur niet annuleren voor order ' . $order->id . ': ' . $e->getMessage());
                }
            }

            $invoiceUpdate = ['status' => 'cancelled', 'updated_at' => now()];
            if ($cancelledPdfPath) {
                $invoiceUpdate['pdf_url'] = $cancelledPdfPath;
            }

            DB::table('invoices')->where('order_id', $order->id)->update($invoiceUpdate);

            $order->status = 'cancelled';
            $order->save();
        }

        // Annuleringsmail sturen naar de klant: eerst het sjabloon van de escaperoom proberen,
        // anders terugvallen op de ingebouwde mail.
        $customerEmail = $order?->customer?->email ?? $order?->customer_email;
        if ($customerEmail && $order) {
            $sentCustomTemplate = $mailTemplateService->sendForRoomCancellation($timeSlot, $order, $voucher);

            if (! $sentCustomTemplate) {
                $mail = new BookingCancelledMail($timeSlot, $order, $escaperoom, $voucher);
                Mail::to($customerEmail)->send($mail);
                $mailTemplateService->logMail($order, 'room_cancellation', $mail->envelope()->subject ?? '', $mail->render());
            }
        }

        return response()->json([
            'ok'           => true,
            'action'       => $action,
            'voucher_code' => $voucher?->code,
        ]);
    }
}
