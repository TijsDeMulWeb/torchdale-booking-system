<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateRoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $escaperoomAddresses = auth()->user()->escaperoom->escaperoomAddresses()->get();
        return view('rooms.create', [
            'escaperoomAddresses' => $escaperoomAddresses
        ]);
    }
}
