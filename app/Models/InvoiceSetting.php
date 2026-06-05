<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
