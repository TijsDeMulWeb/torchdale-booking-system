<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['escaperoom_id', 'name', 'public_key', 'secret_hash', 'allowed_origin', 'is_active', 'last_used_at'])]
class ApiKey extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
