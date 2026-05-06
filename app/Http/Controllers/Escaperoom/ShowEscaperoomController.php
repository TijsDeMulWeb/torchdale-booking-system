<?php

namespace App\Http\Controllers\Escaperoom;

use App\Http\Controllers\Controller;
use App\Models\Escaperoom;
use App\Models\EscaperoomAddress;
use Auth;
use Illuminate\Http\Request;

class ShowEscaperoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('escaperoom.show', [
            'escaperoom' => Auth()->user()->escaperoom()->firstOrFail(),
            'escaperoomAddresses' => EscaperoomAddress::where('escaperoom_id', Auth()->user()->escaperoom_id)->get(),
        ]);
    }
}
