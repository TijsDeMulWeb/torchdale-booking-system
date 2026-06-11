<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['room_id', 'language_id', 'start_time', 'end_time', 'reserved_until', 'blocked_at', 'blocked_reason', 'reminder_sent_at'])]
class TimeSlot extends Model
{
    use SoftDeletes;
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'reserved_until' => 'datetime',
        'blocked_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }
}
