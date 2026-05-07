<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function escaperoom(){
        return $this->belongsTo(Escaperoom::class);
    }
}
