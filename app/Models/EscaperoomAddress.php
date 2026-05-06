<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'street', 'house_number', 'postal_code', 'city', 'country_id', 'is_primary'])]
class EscaperoomAddress extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
