<?php

namespace App\Models;

use App\Support\ContactNormalizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['customer_id', 'type', 'value'])]
class CustomerIdentifier extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = $value;

        $this->attributes['value_normalized'] = match ($this->attributes['type'] ?? null) {
            'email' => ContactNormalizer::normalizeEmail($value),
            'phone' => ContactNormalizer::normalizePhone($value),
            default => $value,
        };
    }
}
