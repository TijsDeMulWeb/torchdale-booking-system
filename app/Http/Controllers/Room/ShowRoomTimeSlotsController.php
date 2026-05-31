<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowRoomTimeSlotsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        return view('rooms.timeslots', [
            'room' => $room,
            'slots' => $room->timeSlots()->get()->groupBy('day_of_week'),
        ]);
    }
}
