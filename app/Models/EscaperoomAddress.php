<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
