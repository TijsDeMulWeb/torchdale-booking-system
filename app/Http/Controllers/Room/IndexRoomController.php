<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rooms = auth()->user()->escaperoom->rooms()->with('escaperoomAddress')->paginate(10);

        return view('rooms.index', [
            'rooms' => $rooms,
        ]);
    }
}
