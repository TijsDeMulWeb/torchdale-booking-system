<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Http\Request;

class UpdateRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRoomRequest $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);
        abort_if($room->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $room->update($request->validated());
        return redirect()->route('rooms.index')->with('message', 'Kamer updated successfully.');
    }
}
