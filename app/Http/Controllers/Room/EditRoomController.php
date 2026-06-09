<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        return view('rooms.edit', [
            'room'               => auth()->user()->escaperoom->rooms()->with('languages')->findOrFail($id),
            'escaperoomAddresses' => auth()->user()->escaperoom->escaperoomAddresses()->get(),
            'languages'          => \App\Models\Language::orderBy('name')->get(),
        ]);
    }
}
