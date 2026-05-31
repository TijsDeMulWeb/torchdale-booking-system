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
        $rooms = $request->escaperoom->escaperoomAddresses()->with('rooms')->get();

        return response()->json(['success' => true, 'addresses' => $rooms]);
    }
}
