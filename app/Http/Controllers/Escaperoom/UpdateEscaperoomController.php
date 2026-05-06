<?php

namespace App\Http\Controllers\Escaperoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEscaperoomRequest;

class UpdateEscaperoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEscaperoomRequest $request)
    {
        auth()->user()->escaperoom->update($request->escaperoomData());
        auth()->user()->escaperoom->escaperoomSetting->update($request->escaperoomSettingsData());

        return redirect()->route('escaperoom.show')->with('message', 'Escaperoom updated successfully.');
    }
}
