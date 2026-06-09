<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['escaperoom_id', 'code', 'amount', 'customer_id', 'order_id', 'gift_card_id', 'source', 'status', 'valid_until', 'used_at', 'used_order_id'])]
class GiftVoucher extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'valid_until' => 'datetime',
            'used_at'     => 'datetime',
            'amount'      => 'decimal:2',
        ];
    }

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function giftCard()
    {
        return $this->belongsTo(GiftCard::class);
    }

    public function usedOrder()
    {
        return $this->belongsTo(Order::class, 'used_order_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && ($this->valid_until === null || $this->valid_until->isFuture());
    }
}
