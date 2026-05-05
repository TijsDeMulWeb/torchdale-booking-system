<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function escaperoomAddresses()
    {
        return $this->hasMany(EscaperoomAddress::class);
    }
}
