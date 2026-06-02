<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['customer_id', 'coupon_id', 'total', 'subtotal', 'discount', 'vat_rate', 'vat_amount', 'status', 'payment_method', 'invoice_number'])]
class Order extends Model
{
    use SoftDeletes;
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }
}
