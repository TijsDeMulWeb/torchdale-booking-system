<?php

namespace App\Http\Controllers\AccountSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountSetupRequest;
use App\Models\ApiKey;
use App\Models\User;

class StoreAccountSetupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreAccountSetupRequest $request)
    {
        $data = $request->validated();

        $apiKey = ApiKey::where('public_key', $data['key'])->first();

        if (!$apiKey) {
            return redirect()->route('register')->withErrors(['message' => 'Deze link is ongeldig of verlopen.']);
        }

        $escaperoom = $apiKey->escaperoom;

        if ($escaperoom->users()->exists()) {
            return redirect()->route('login')->withErrors(['message' => 'Er is al een account gekoppeld aan deze escaperoom. Log in met je e-mailadres en wachtwoord.']);
        }

        $user = new User();
        $user->fill([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'language' => 'nl',
        ]);
        $user->escaperoom_id = $escaperoom->id;
        $user->password = $data['password'];
        $user->password_set_at = now();
        $user->save();

        User::find($user->id)->assignRole('admin');


        return redirect()->route('login')->with('message', 'Je account is aangemaakt! Je kan nu inloggen met je e-mailadres en wachtwoord.');
    }
}
