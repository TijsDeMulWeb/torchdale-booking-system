<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEscaperoomAddressRequest;
use App\Models\EscaperoomAddress;

class UpdateEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEscaperoomAddressRequest $request, $id = null)
    {
        $address = EscaperoomAddress::findOrFail($id);

        abort_if($address->escaperoom_id !== Auth()->user()->escaperoom_id, 403);

        $address->update($request->validated());

        return redirect()->route('escaperoom.show')->with('message', 'Address updated successfully.');
    }
}
