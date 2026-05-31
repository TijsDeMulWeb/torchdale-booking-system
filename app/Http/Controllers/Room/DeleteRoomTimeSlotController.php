<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteRoomTimeSlotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $room = auth()->user()->company->rooms()->findOrFail($id);

        $room->timeSlots()->delete();

        return redirect()->route('rooms.timeslots.show', $room->id)->with('message', 'Tijdsloten succesvol verwijderd.');
    }
}
