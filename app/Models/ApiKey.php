<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['escaperoom_id', 'name', 'public_key', 'secret_hash', 'allowed_origin', 'is_active', 'last_used_at'])]
class ApiKey extends Model
{
    use SoftDeletes;
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function setAllowedOriginAttribute($value)
    {
        $this->attributes['allowed_origin'] = rtrim($value, '/');
    }
}
