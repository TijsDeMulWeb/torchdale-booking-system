<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;

class GetBookingDetailsController extends Controller
{
    public function __invoke(TimeSlot $timeSlot)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $timeSlot->load(['room', 'language', 'orderedItems.order.customer', 'orderedItems.order.invoice']);

        $orderedItem = $timeSlot->orderedItems->first();
        $order       = $orderedItem?->order;
        $customer    = $order?->customer;
        $invoice     = $order?->invoice;

        $customerName = $customer
            ? trim("{$customer->first_name} {$customer->last_name}")
            : ($order ? trim("{$order->customer_first_name} {$order->customer_last_name}") : null);

        return response()->json([
            'id'             => $timeSlot->id,
            'room'           => $timeSlot->room?->name,
            'room_color'     => $timeSlot->room?->color,
            'date'           => $timeSlot->start_time?->translatedFormat('l d F Y'),
            'start'          => $timeSlot->start_time?->format('H:i'),
            'end'            => $timeSlot->end_time?->format('H:i'),
            'language'       => $timeSlot->language?->name,
            'players'        => $orderedItem?->quantity,

            // Customer
            'customer_name'  => $customerName,
            'customer_email' => $customer?->email  ?? $order?->customer_email,
            'customer_phone' => $customer?->phone  ?? $order?->customer_phone,

            // Payment
            'total'              => $order ? (float) $order->total              : null,
            'amount_online'      => $order ? (float) $order->amount_online      : 0,
            'amount_onsite'      => $order ? (float) $order->amount_onsite      : 0,
            'amount_paid_online' => $order ? (float) $order->amount_paid_online : 0,
            'amount_paid_onsite' => $order ? (float) $order->amount_paid_onsite : 0,
            'status'             => $order?->status,
            'payment_method'     => $order?->payment_method,

            // Invoice (receipt) — only exists after webhook confirms payment
            'invoice_pdf_url'  => ($invoice?->pdf_url) ? route('orders.invoice', ['order' => $order->id]) : null,
            'invoice_number'   => $invoice?->invoice_number ?? $order?->invoice_number,

            // Step tracking
            'steps' => [
                'invoice_sent'  => !empty($order?->mollie_id),   // Betaallink verstuurd (mollie_id on order)
                'paid'          => $order?->status === 'paid',   // Betaald
                'receipt_sent'  => $invoice !== null && $invoice->status === 'paid', // Betaalde factuur ontvangen
            ],

            'order_id' => $order?->id,
        ])->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma'        => 'no-cache',
        ]);
    }
}
