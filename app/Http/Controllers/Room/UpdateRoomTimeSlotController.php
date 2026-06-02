<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTimeslotRequest;
use App\Models\RoomTimeSlot;
use Illuminate\Http\Request;

class UpdateRoomTimeslotController extends Controller
{
    public function __invoke(StoreRoomTimeslotRequest $request, int $id, RoomTimeSlot $timeslot)
    {
        abort_if($timeslot->room->escaperoom_id !== auth()->user()->escaperoom->id, 403);

        $timeslot->update($request->validated());

        return redirect()->route('rooms.timeslots.show', $id)->with('message', 'Tijdslot bijgewerkt.');
    }
}