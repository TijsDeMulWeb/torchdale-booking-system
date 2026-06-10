<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Models\Language;
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
            'escaperoomAddresses' => $escaperoomAddresses,
            'languages'           => Language::orderBy('name')->get(),
        ]);
    }
}
