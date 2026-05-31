<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);
        abort_if($room->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $room->delete();

        return redirect()->route('rooms.index')->with('message', 'Room deleted successfully.');
    }
}
