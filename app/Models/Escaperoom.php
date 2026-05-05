<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escaperoom extends Model
{
    public function escaperoomAddresses()
    {
        return $this->hasMany(EscaperoomAddress::class);
    }
}
