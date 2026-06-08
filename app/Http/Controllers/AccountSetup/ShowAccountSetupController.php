<?php

namespace App\Http\Controllers\AccountSetup;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ShowAccountSetupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $apiKey = ApiKey::where('public_key', $request->query('key'))->first();

        if (!$apiKey) {
            abort(404, 'Deze link is ongeldig of verlopen.');
        }

        $escaperoom = $apiKey->escaperoom;

        if ($escaperoom->users()->exists()) {
            return redirect()->route('login')->with('message', 'Er bestaat al een account voor deze escaperoom. Log in met je gegevens.');
        }

        return view('accountSetup.show', [
            'escaperoom' => $escaperoom,
            'key' => $apiKey->public_key,
        ]);
    }
}
