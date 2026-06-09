<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancelledMail;
use App\Models\TimeSlot;
use App\Services\GiftVoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CancelBookingController extends Controller
{
    public function __invoke(Request $request, TimeSlot $timeSlot, GiftVoucherService $voucherService)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $action = $request->input('action', 'cancel'); // cancel | voucher

        $timeSlot->loadMissing(['room', 'language', 'orderedItems.order.customer']);
        $orderedItem = $timeSlot->orderedItems->first();
        $order       = $orderedItem?->order;

        $voucher = null;

        if ($action === 'voucher' && $order) {
            $voucher = $voucherService->createForCancellation($order);
        }

        $timeSlot->delete(); // soft delete

        // Bevestigingsmail sturen naar de klant
        $customerEmail = $order?->customer?->email ?? $order?->customer_email;
        if ($customerEmail && $order) {
            Mail::to($customerEmail)->send(
                new BookingCancelledMail($timeSlot, $order, $escaperoom, $voucher)
            );
        }

        return response()->json([
            'ok'           => true,
            'action'       => $action,
            'voucher_code' => $voucher?->code,
        ]);
    }
}
