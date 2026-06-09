<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManualBookingRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StoreManualBookingController extends Controller
{
    public function __invoke(StoreManualBookingRequest $request)
    {
        $data = $request->validated();
        $escaperoom = $request->user()->escaperoom;

        $room = $escaperoom->rooms()->findOrFail($data['room_id']);

        $start = Carbon::parse("{$data['date']} {$data['start']}");
        $end = Carbon::parse("{$data['date']} {$data['end']}");

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $hasConflict = TimeSlot::where('room_id', $room->id)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['message' => 'Dit tijdslot is ondertussen al bezet of geblokkeerd.']);
        }

        $dayOfWeek = $start->dayOfWeekIso - 1;
        $roomPrice = $room->prices()->where('day_of_week', $dayOfWeek)->where('player_amount', $data['players'])->first();

        // Use custom price if provided, otherwise fall back to price table
        $customPrice = isset($data['custom_price']) && $data['custom_price'] !== '' ? (float) $data['custom_price'] : null;
        $vatPct = $roomPrice?->vat_percentage ?? 6;
        $unitPrice = $customPrice ?? ($roomPrice?->price ?? 0);

        if (!$roomPrice && $customPrice === null) {
            return back()->withErrors(['message' => "Geen prijs gevonden voor {$data['players']} spelers op deze dag. Vul een manuele prijs in."]);
        }

        DB::transaction(function () use ($escaperoom, $room, $roomPrice, $start, $end, $data, $unitPrice, $vatPct) {
            $customer = $this->matchOrCreateCustomer($escaperoom, $data);

            $total      = round($unitPrice, 2);
            $subtotal   = round($total / (1 + $vatPct / 100), 2);
            $vatAmount  = round($total - $subtotal, 2);
            $amtOnline  = round((float) ($data['amount_online'] ?? 0), 2);
            $amtOnsite  = round((float) ($data['amount_onsite'] ?? 0), 2);

            $order = new Order();
            $order->escaperoom_id = $escaperoom->id;
            $order->customer_id = $customer->id;
            $order->customer_first_name = $customer->first_name;
            $order->customer_last_name = $customer->last_name;
            $order->customer_email = $customer->email;
            $order->customer_phone = $customer->phone;
            $order->total = $total;
            $order->amount_online = $amtOnline;
            $order->amount_onsite = $amtOnsite;
            $order->subtotal = $subtotal;
            $order->discount = 0;
            $order->vat_amount = $vatAmount;
            $order->status = 'paid';
            $order->payment_method = 'manual';
            $order->save();

            $timeSlot = TimeSlot::create([
                'room_id'     => $room->id,
                'language_id' => $data['language_id'] ?? null,
                'start_time'  => $start,
                'end_time'    => $end,
            ]);

            $order->orderedItems()->create([
                'time_slot_id'   => $timeSlot->id,
                'quantity'       => $data['players'],
                'unit_price'     => $unitPrice,
                'total_price'    => $total,
                'vat_percentage' => $vatPct,
                'vat_amount'     => $vatAmount,
            ]);
        });

        return back()->with('message', 'Afspraak aangemaakt.');
    }

    private function matchOrCreateCustomer($escaperoom, array $data): Customer
    {
        $customer = $escaperoom->customers()
            ->where('email', strtolower(trim($data['email'])))
            ->first();

        if ($customer) {
            return $customer;
        }

        return $escaperoom->customers()->create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? null,
            'street'       => $data['street'] ?? null,
            'house_number' => $data['house_number'] ?? null,
            'postal_code'  => $data['postal_code'] ?? null,
            'city'         => $data['city'] ?? null,
        ]);
    }
}
