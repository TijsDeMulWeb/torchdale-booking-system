<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['room_id', 'start_time', 'end_time', 'blocked_at', 'blocked_reason'])]
class TimeSlot extends Model
{
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }
}
