<?php

namespace App\Services;

use App\Models\GiftVoucher;
use App\Models\Order;
use App\Models\OrderedItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GiftVoucherService
{
    /**
     * Genereer een unieke 4x4-cijferige code: XXXX-XXXX-XXXX-XXXX
     */
    public function generateCode(): string
    {
        do {
            $code = implode('-', [
                str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
                str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
                str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
                str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT),
            ]);
        } while (GiftVoucher::where('code', $code)->exists());

        return $code;
    }

    /**
     * Maak cadeaubonnen aan voor alle gift_card-items in een order die betaald is.
     * Wordt aangeroepen vanuit webhook (online) en StoreOrderController (cash).
     */
    public function createForPaidOrder(Order $order): int
    {
        $order->loadMissing('orderedItems.giftCard');

        $created = 0;

        foreach ($order->orderedItems as $item) {
            if (!$item->gift_card_id) {
                continue;
            }

            // Voorkom dubbele aanmaak
            $alreadyExists = GiftVoucher::where('order_id', $order->id)
                ->where('gift_card_id', $item->gift_card_id)
                ->exists();

            if ($alreadyExists) {
                continue;
            }

            // Maak een bon aan per besteld item (qty = 1 normaal, maar voor de zekerheid loop we qty keer)
            $qty = max(1, (int) $item->quantity);
            for ($i = 0; $i < $qty; $i++) {
                $validUntil = $item->giftCard?->valid_until;

                GiftVoucher::create([
                    'escaperoom_id' => $order->escaperoom_id,
                    'code'          => $this->generateCode(),
                    'amount'        => $item->unit_price,
                    'customer_id'   => $order->customer_id,
                    'order_id'      => $order->id,
                    'gift_card_id'  => $item->gift_card_id,
                    'source'        => 'purchase',
                    'status'        => 'active',
                    'valid_until'   => $validUntil,
                ]);

                $created++;
            }
        }

        if ($created > 0) {
            Log::info("GiftVoucherService: {$created} bon(nen) aangemaakt voor order #{$order->id}");
        }

        return $created;
    }

    /**
     * Maak een cadeaubon aan als vergoeding bij annulering van een boeking.
     * Bedrag = totaalbedrag van de order.
     */
    public function createForCancellation(Order $order, ?string $validityMonths = '12'): GiftVoucher
    {
        $validUntil = $validityMonths
            ? now()->addMonths((int) $validityMonths)
            : null;

        return GiftVoucher::create([
            'escaperoom_id' => $order->escaperoom_id,
            'code'          => $this->generateCode(),
            'amount'        => $order->total,
            'customer_id'   => $order->customer_id,
            'order_id'      => $order->id,
            'source'        => 'cancellation',
            'status'        => 'active',
            'valid_until'   => $validUntil,
        ]);
    }
}
