<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTimeSlotRequest;

class StoreRoomTimeSlotController extends Controller
{
    public function __invoke(StoreRoomTimeSlotRequest $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        $room->timeSlots()->create($request->validated());

        return redirect()->route('rooms.timeslots.show', $id)->with('message', 'Tijdslot toegevoegd.');
    }
}