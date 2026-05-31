<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['room_id', 'base_price', 'price', 'player_amount', 'day_of_week', 'vat_percentage', 'payment_location'])]
class RoomPrice extends Model
{
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
