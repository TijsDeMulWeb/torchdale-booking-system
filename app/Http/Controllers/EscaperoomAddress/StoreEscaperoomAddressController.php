<?php

namespace App\Http\Controllers\EscaperoomAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEscaperoomAddressRequest;
use App\Models\EscaperoomAddress;

class StoreEscaperoomAddressController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEscaperoomAddressRequest $request)
    {
        $validated = $request->validated();

        $countPrimaryAddress = EscaperoomAddress::where('escaperoom_id', auth()->user()->escaperoom_id)
            ->where('is_primary', true)->count();

        if ($countPrimaryAddress === 0) {
            $validated['is_primary'] = true;
        }

        if ($countPrimaryAddress > 0 && $request->is_primary) {
            EscaperoomAddress::where('escaperoom_id', auth()->user()->escaperoom_id)
                ->where('is_primary', true)->first()->update(['is_primary' => false]);
        }

        EscaperoomAddress::create([...$validated, 'escaperoom_id' => auth()->user()->escaperoom_id]);

        return redirect()->route('escaperoom.show')->with('message', 'Address succesvol toegevoegd.');
    }
}
