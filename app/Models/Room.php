<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_address_id', 'name', 'duration', 'min_players', 'max_players', 'min_age', 'url', 'active_from', 'active_until', 'max_booking_advance', 'color'])]
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

    protected function casts(): array
    {
        return [
            'active_from' => 'datetime',
            'active_until' => 'datetime',
        ];
    }
}
