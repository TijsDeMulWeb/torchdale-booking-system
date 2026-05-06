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
        $address = EscaperoomAddress::findOrFail($id);

        abort_if($address->escaperoom_id !== auth()->user()->escaperoom_id, 403);
        
        return view('escaperoomAddress.edit', [
            'escaperoomAddress' => $address,
            'countries' => Country::orderBy('name')->get()
        ]);
    }
}
