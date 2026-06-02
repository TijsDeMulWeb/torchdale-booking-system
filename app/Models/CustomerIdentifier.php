<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['customer_id', 'type', 'value'])]
class CustomerIdentifier extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
