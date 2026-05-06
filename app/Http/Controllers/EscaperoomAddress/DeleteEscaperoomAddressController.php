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
        $escaperoomAddress = EscaperoomAddress::findOrFail($id);
        $escaperoomAddress->delete();

        return redirect()->route('escaperoom.show')->with('success', 'Adres succesvol verwijderd.');
    }
}
