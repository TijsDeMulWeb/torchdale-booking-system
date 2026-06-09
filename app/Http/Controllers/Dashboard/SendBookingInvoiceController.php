<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use App\Services\MollieBookingInvoiceService;

class SendBookingInvoiceController extends Controller
{
    public function __invoke(TimeSlot $timeSlot, MollieBookingInvoiceService $invoiceService)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $timeSlot->load(['room', 'language', 'orderedItems.order.customer']);

        $orderedItem = $timeSlot->orderedItems->first();
        $order       = $orderedItem?->order;

        if (!$order || !$order->customer) {
            return response()->json(['error' => 'Geen bestelling of klant gevonden voor dit tijdslot.'], 422);
        }

        if ($order->mollie_id) {
            return response()->json(['error' => 'Er is al een betaallink verstuurd voor deze boeking.'], 422);
        }

        $mollieKey = $escaperoom->escaperoomSetting?->mollie_api_key;
        if (!$mollieKey) {
            return response()->json(['error' => 'Geen Mollie API-sleutel ingesteld.'], 422);
        }

        $order->load('customer');
        $ok = $invoiceService->send($order, $timeSlot, $mollieKey);

        if (!$ok) {
            return response()->json(['error' => 'Betaallink versturen mislukt. Controleer de logs.'], 500);
        }

        return response()->json(['ok' => true]);
    }
}
