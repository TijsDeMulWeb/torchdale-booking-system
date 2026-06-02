<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'code', 'amount', 'valid_from', 'valid_until'])]
class GiftCard extends Model
{
    use softDeletes;

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }

    protected function casts(): array
    {
        return [
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
        ];
    }
}
