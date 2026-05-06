<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'prompt'])]
class Chatbot extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
