<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\RoomTimeSlot;
use Illuminate\Http\Request;

class StoreRoomTimeslotController extends Controller
{
    public function __invoke(Request $request, int $roomId)
    {
        $request->validate([
            'day_of_week' => ['required', 'integer', 'between:0,6'],
            'start_time'  => ['required', 'date_format:H:i'],
            'end_time'    => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $room = auth()->user()->escaperoom->rooms()->findOrFail($roomId);

        $room->timeSlots()->create([
            'day_of_week' => $request->day_of_week,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
        ]);

        return redirect()->route('rooms.timeslots.show', $roomId)
            ->with('message', 'Tijdslot toegevoegd.');
    }
}