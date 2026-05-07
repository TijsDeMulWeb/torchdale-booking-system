<?php

namespace App\Http\Controllers\Escaperoom;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEscaperoomRequest;
use Illuminate\Support\Facades\Storage;

class UpdateEscaperoomController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEscaperoomRequest $request)
    {
        $escaperoom = auth()->user()->escaperoom;

        $data = $request->escaperoomData();

        if ($request->hasFile('logo')) {
            if ($escaperoom->logo_url) {
                Storage::disk('public')->delete($escaperoom->logo_url);
            }

            $path = $request->file('logo')
                ->store('escaperooms/logo', 'public');

            $data['logo_url'] = $path;
        }

        $escaperoom->update($data);

        $escaperoom->escaperoomSetting
            ->update($request->escaperoomSettingsData());

        return redirect()
            ->route('escaperoom.show')
            ->with('message', 'Escaperoom succesvol bijgewerkt.');
    }
}
