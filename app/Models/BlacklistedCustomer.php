<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Routing\Loader\Configurator\Traits\AddTrait;

#[Fillable(['escaperoom_id', 'customer_id', 'mail', 'ip_address'])]
class BlacklistedCustomer extends Model
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
}
