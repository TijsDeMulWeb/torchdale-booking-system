<?php

namespace App\Http\Controllers\Escaperoom;

use App\Http\Controllers\Controller;
use App\Models\EscaperoomAddress;
use Illuminate\Http\Request;

class EditEscaperoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('escaperoom.edit', [
            'escaperoom' => Auth()->user()->escaperoom()->firstOrFail(),
            'escaperoomAddresses' => EscaperoomAddress::where('escaperoom_id', Auth()->user()->escaperoom_id)->get(),
        ]);
    }
}
