<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Support\Facades\Storage;

class UpdateRoomController extends Controller
{
    public function __invoke(StoreRoomRequest $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('url')) {
            if ($room->url) {
                Storage::disk('public')->delete($room->url);
            }

            $imageFile = $validated['url'];
            unset($validated['url']);

            $room->update($validated);

            $room->url = $imageFile->store(
                'escaperooms/' . auth()->user()->escaperoom->id . '/rooms/' . $room->id,
                'public'
            );
            $room->save();
        } else {
            unset($validated['url']);
            $room->update($validated);
        }

        return redirect()->route('rooms.index')->with('message', 'Kamer updated successfully.');
    }
}