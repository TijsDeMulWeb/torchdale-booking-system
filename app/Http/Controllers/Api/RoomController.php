<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rooms = $request->escaperoom->rooms()->with('escaperoomAddress')->get();

        return response()->json(['success' => true, 'rooms' => $rooms]);
    }
}
