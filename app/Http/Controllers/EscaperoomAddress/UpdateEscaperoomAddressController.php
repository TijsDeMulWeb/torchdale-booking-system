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
    public function __invoke(StoreEscaperoomAddressRequest $request, $id)
    {
        $address = EscaperoomAddress::findOrFail($id);

        abort_if($address->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        if ($address->is_primary) {
            EscaperoomAddress::where('escaperoom_id', auth()->user()->escaperoom_id)
                ->where('id', '!=', $address->id)->first()->update(['is_primary' => true]);
        }

        $address->update($request->validated());

        return redirect()->route('escaperoom.show')->with('message', 'Address updated successfully.');
    }
}
