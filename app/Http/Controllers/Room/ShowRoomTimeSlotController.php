<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowRoomTimeslotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        return view('rooms.timeslots', [
            'room' => $room,
            'slots' => $room->timeSlots()->orderBy('start_time')->get()->groupBy('day_of_week'),
            'last_updated' => $room->timeSlots()->latest('updated_at')->first(),
        ]);
    }
}
