<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description', 'code', 'discount_type', 'discount_value', 'valid_from', 'valid_until', 'usage_limit', 'times_used'])]
class Coupon extends Model
{
    use SoftDeletes;

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function casts(): array
    {
        return [
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
        ];
    }
}
