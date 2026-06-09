<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class MarkOnsitePaymentController extends Controller
{
    public function __invoke(TimeSlot $timeSlot, Request $request)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $orderedItem = $timeSlot->orderedItems()->first();
        $order = $orderedItem?->order;

        abort_unless($order, 404);

        $amount = round((float) $request->input('amount', $order->amount_onsite ?? 0), 2);

        $order->amount_paid_onsite = $amount;

        $totalPaid = ((float) $order->amount_paid_online) + $amount;
        if ($totalPaid >= (float) $order->total) {
            $order->status = 'paid';
        }

        $order->save();

        return response()->json([
            'ok'               => true,
            'amount_paid_onsite' => (float) $order->amount_paid_onsite,
            'amount_paid_online' => (float) $order->amount_paid_online,
            'status'           => $order->status,
        ]);
    }
}
