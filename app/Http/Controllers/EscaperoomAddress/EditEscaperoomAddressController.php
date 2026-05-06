<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EscaperoomAddress;
use Illuminate\Http\Request;

class EditEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        return view('escaperoomAddress.edit', [
            'escaperoomAddress' => EscaperoomAddress::where('escaperoom_id', Auth()->user()->escaperoom_id)->where('id', $id)->firstOrFail(),
            'countries' => Country::orderBy('name')->get()
        ]);
    }
}
