<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManualBookingRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\TimeSlot;
use App\Services\MollieBookingInvoiceService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StoreManualBookingController extends Controller
{
    public function __invoke(StoreManualBookingRequest $request, MollieBookingInvoiceService $invoiceService)
    {
        $data       = $request->validated();
        $escaperoom = $request->user()->escaperoom;

        // Idempotency: prevent duplicate submissions
        $idempotencyKey = $request->input('idempotency_key');
        if ($idempotencyKey) {
            $cacheKey = 'manual_booking_' . auth()->id() . '_' . $idempotencyKey;
            if (!Cache::add($cacheKey, true, now()->addMinutes(5))) {
                return back()->with('message', 'Afspraak aangemaakt.');
            }
        }

        $room = $escaperoom->rooms()->findOrFail($data['room_id']);

        $start = Carbon::parse("{$data['date']} {$data['start']}");
        $end   = Carbon::parse("{$data['date']} {$data['end']}");

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

        $dayOfWeek  = $start->dayOfWeekIso - 1;
        $roomPrice  = $room->prices()->where('day_of_week', $dayOfWeek)->where('player_amount', $data['players'])->first();
        $customPrice = isset($data['custom_price']) && $data['custom_price'] !== '' ? (float) $data['custom_price'] : null;
        $vatPct      = $roomPrice?->vat_percentage ?? 6;
        $unitPrice   = $customPrice ?? ($roomPrice?->price ?? 0);

        if (!$roomPrice && $customPrice === null) {
            return back()->withErrors(['message' => "Geen prijs gevonden voor {$data['players']} spelers op deze dag. Vul een manuele prijs in."]);
        }

        [$order, $timeSlot] = DB::transaction(function () use ($escaperoom, $room, $start, $end, $data, $unitPrice, $vatPct) {
            $customer  = $this->matchOrCreateCustomer($escaperoom, $data);

            $total     = round($unitPrice, 2);
            $subtotal  = round($total / (1 + $vatPct / 100), 2);
            $vatAmount = round($total - $subtotal, 2);
            $amtOnline = round((float) ($data['amount_online'] ?? 0), 2);
            $amtOnsite = round((float) ($data['amount_onsite'] ?? 0), 2);

            $order = new Order();
            $order->escaperoom_id        = $escaperoom->id;
            $order->customer_id          = $customer->id;
            $order->customer_first_name  = $customer->first_name;
            $order->customer_last_name   = $customer->last_name;
            $order->customer_email       = $customer->email;
            $order->customer_phone       = $customer->phone;
            $order->total                = $total;
            $order->amount_online        = $amtOnline;
            $order->amount_onsite        = $amtOnsite;
            $order->subtotal             = $subtotal;
            $order->discount             = 0;
            $order->vat_amount           = $vatAmount;
            $order->status               = 'pending';
            $order->payment_method       = 'manual';
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

            return [$order, $timeSlot];
        });

        // Send Mollie invoice outside the transaction (network call)
        $mollieKey = $escaperoom->escaperoomSetting?->mollie_api_key;
        if ($mollieKey) {
            $timeSlot->load(['room', 'language', 'orderedItems']);
            $order->load('customer');
            $invoiceService->send($order, $timeSlot, $mollieKey);
        }

        return back()->with('message', 'Afspraak aangemaakt.');
    }

    private function matchOrCreateCustomer($escaperoom, array $data): Customer
    {
        $email = strtolower(trim($data['email'] ?? ''));

        // Primaire match: op e-mailadres
        $customer = $escaperoom->customers()
            ->where('email', $email)
            ->first();

        // Secundaire match: zelfde voor- + achternaam (voorkomt duplicaten bij ander e-mailadres)
        if (!$customer) {
            $customer = $escaperoom->customers()
                ->whereRaw('LOWER(first_name) = ?', [strtolower(trim($data['first_name']))])
                ->whereRaw('LOWER(last_name) = ?', [strtolower(trim($data['last_name']))])
                ->first();
        }

        if ($customer) {
            // Vul ontbrekende contactgegevens aan op het bestaande record
            $updates = array_filter([
                'email'        => ($customer->email ? null : $email) ?: null,
                'phone'        => ($customer->phone ? null : ($data['phone'] ?? null)),
                'street'       => ($customer->street ? null : ($data['street'] ?? null)),
                'house_number' => ($customer->house_number ? null : ($data['house_number'] ?? null)),
                'postal_code'  => ($customer->postal_code ? null : ($data['postal_code'] ?? null)),
                'city'         => ($customer->city ? null : ($data['city'] ?? null)),
            ]);
            if ($updates) {
                $customer->fill($updates)->save();
            }
            return $customer;
        }

        return $escaperoom->customers()->create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $email,
            'phone'        => $data['phone'] ?? null,
            'street'       => $data['street'] ?? null,
            'house_number' => $data['house_number'] ?? null,
            'postal_code'  => $data['postal_code'] ?? null,
            'city'         => $data['city'] ?? null,
        ]);
    }
}
