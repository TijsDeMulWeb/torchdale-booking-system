<?php

namespace App\Console\Commands;

use App\Models\GiftVoucher;
use App\Models\TimeSlot;
use Illuminate\Console\Command;

class ReleaseExpiredTimeSlotReservations extends Command
{
    protected $signature = 'bookings:release-expired-reservations';

    protected $description = 'Geef tijdelijk gereserveerde tijdslots vrij waarvan de betaling niet binnen 15 minuten is voltooid';

    public function handle(): int
    {
        $expiredSlots = TimeSlot::whereNotNull('reserved_until')
            ->where('reserved_until', '<', now())
            ->with('orderedItems.order')
            ->get();

        $processedOrderIds = [];
        $released = 0;

        foreach ($expiredSlots as $timeSlot) {
            foreach ($timeSlot->orderedItems as $orderedItem) {
                $order = $orderedItem->order;

                if (!$order || $order->status !== 'pending' || in_array($order->id, $processedOrderIds)) {
                    continue;
                }

                $processedOrderIds[] = $order->id;

                $order->loadMissing('orderedItems.product', 'orderedItems.productVariant');

                foreach ($order->orderedItems as $item) {
                    if ($item->product_variant_id && $item->productVariant && $item->productVariant->stock_quantity !== null) {
                        $item->productVariant->stock_quantity += $item->quantity;
                        $item->productVariant->save();
                    } elseif ($item->product_id && $item->product && $item->product->stock_quantity !== null) {
                        $item->product->stock_quantity += $item->quantity;
                        $item->product->save();
                    }
                }

                GiftVoucher::where('used_order_id', $order->id)->where('status', 'used')->get()->each(function (GiftVoucher $voucher) {
                    $voucher->status = 'active';
                    $voucher->used_at = null;
                    $voucher->used_order_id = null;
                    $voucher->save();
                });

                $order->status = 'cancelled';
                $order->save();
            }

            $timeSlot->delete();
            $released++;
        }

        $this->info("{$released} tijdslot(s) vrijgegeven.");

        return self::SUCCESS;
    }
}
