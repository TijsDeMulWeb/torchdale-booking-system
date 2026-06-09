<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['order_id', 'time_slot_id', 'room_id', 'product_id', 'gift_card_id', 'gift_delivery_method', 'gift_shipping_cost', 'quantity', 'unit_price', 'total_price', 'vat_percentage', 'vat_amount'])]
class OrderedItem extends Model
{
    use SoftDeletes;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getItemNameAttribute(): ?string
    {
        if ($this->time_slot_id) {
            return $this->timeSlot?->room?->name;
        }
        if ($this->room_id) {
            return $this->room?->name;
        }
        if ($this->gift_card_id) {
            return $this->giftCard?->name;
        }
        if ($this->product_id) {
            return $this->product?->name;
        }
        return null;
    }
}
