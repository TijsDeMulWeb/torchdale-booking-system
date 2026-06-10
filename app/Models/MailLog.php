<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['escaperoom_id', 'customer_id', 'order_id', 'to_email', 'type', 'subject', 'body'])]
class MailLog extends Model
{
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
}
