<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['escaperoom_address_id', 'name', 'duration', 'min_players', 'max_players', 'min_age', 'url', 'active_from', 'active_until', 'max_booking_advance', 'color'])]
class Room extends Model
{
    use SoftDeletes;
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function escaperoomAddress()
    {
        return $this->belongsTo(EscaperoomAddress::class);
    }

    public function prices()
    {
        return $this->hasMany(RoomPrice::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(RoomTimeSlot::class);
    }

    protected function casts(): array
    {
        return [
            'active_from' => 'datetime',
            'active_until' => 'datetime',
        ];
    }
}
