<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;

class StoreRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRoomRequest $request)
    {
        $validated = $request->validated();
        $imageFile = $validated['url'] ?? null;
        unset($validated['url']);

        $room = new Room($validated);
        $room->escaperoom_id = auth()->user()->escaperoom->id;
        $room->escaperoom_address_id = $validated['escaperoom_address_id'];
        $room->url = '';
        $room->save();

        if ($imageFile) {
            $room->url = $imageFile->store(
                'escaperooms/' . auth()->user()->escaperoom->id . '/rooms/' . $room->id,
                'public'
            );
            $room->save();
        }

        return redirect()->route('rooms.index')->with('message', 'Room created successfully.');
    }
}
