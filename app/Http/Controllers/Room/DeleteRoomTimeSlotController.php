<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteRoomTimeslotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id, int $timeslot)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        $room->timeSlots()->find($timeslot)->delete();

        return redirect()->route('rooms.timeslots.show', $room->id)->with('message', 'Tijdsloten succesvol verwijderd.');
    }
}
