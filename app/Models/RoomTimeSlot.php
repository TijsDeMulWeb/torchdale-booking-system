<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['room_id', 'day_of_week', 'start_time', 'end_time'])]
class RoomTimeSlot extends Model
{
    use softDeletes;
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }
}
