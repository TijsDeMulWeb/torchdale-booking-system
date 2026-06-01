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
        if ($request->address_id) {
            $rooms = $request->escaperoom->escaperoomAddresses()->where('id', $request->address_id)->with(['rooms.prices', 'rooms.timeSlots',])->get();
            return response()->json(['success' => true, 'addresses' => $rooms]);
        }

        $rooms = $request->escaperoom->escaperoomAddresses()->with(['rooms.prices','rooms.timeSlots',])->get();
        return response()->json(['success' => true, 'addresses' => $rooms]);
    }
}
