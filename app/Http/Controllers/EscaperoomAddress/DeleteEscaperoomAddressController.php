<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use App\Models\EscaperoomAddress;
use Illuminate\Http\Request;

class DeleteEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $address = EscaperoomAddress::findOrFail($id);

        abort_if($address->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $amountOfAddresses = EscaperoomAddress::where('escaperoom_id', auth()->user()->escaperoom_id)->count();
        
        if ($amountOfAddresses <= 1) {
            return redirect()->route('escaperoom.show')->withErrors(['message' => 'Je moet minimaal 1 adres hebben.']);
        }

        $escaperoomAddress = EscaperoomAddress::where('escaperoom_id', auth()->user()->escaperoom_id)->where('id', $id)->firstOrFail();

        if ($escaperoomAddress->is_primary) {
            return redirect()->route('escaperoom.show')->withErrors(['message' => 'Je kunt het primaire adres niet verwijderen.']);
        }

        $escaperoomAddress->delete();

        return redirect()->route('escaperoom.show')->with('message', 'Adres succesvol verwijderd.');
    }
}
