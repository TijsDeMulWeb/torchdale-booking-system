<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function escaperoomAddress()
    {
        return $this->belongsTo(EscaperoomAddress::class);
    }
}
