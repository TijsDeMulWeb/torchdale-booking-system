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
            'total'          => $order?->total          ? number_format((float) $order->total,         2, ',', '.') : null,
            'amount_online'  => $order?->amount_online  ? number_format((float) $order->amount_online, 2, ',', '.') : '0,00',
            'amount_onsite'  => $order?->amount_onsite  ? number_format((float) $order->amount_onsite, 2, ',', '.') : '0,00',
            'status'         => $order?->status,
            'payment_method' => $order?->payment_method,

            // Invoice
            'invoice_pdf_url'  => $invoice?->pdf_url,
            'invoice_number'   => $invoice?->invoice_number ?? $order?->invoice_number,

            'order_id' => $order?->id,
        ]);
    }
}
