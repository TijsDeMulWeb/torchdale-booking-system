<?php

namespace App\Http\Controllers\PasswordSetup;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePasswordSetupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StorePasswordSetupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePasswordSetupRequest $request, User $user)
    {
        if ($user->password_set_at !== null) {
            return redirect()->route('login')->withErrors([
                'message' => 'Deze link is al gebruikt. Log in met je e-mailadres en wachtwoord, of vraag een nieuwe link aan via je beheerder.',
            ]);
        }

        $user->password = $request->validated()['password'];
        $user->password_set_at = now();
        $user->email_verified_at = $user->email_verified_at ?? now();
        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard.show')->with('message', 'Je wachtwoord is ingesteld. Welkom!');
    }
}
