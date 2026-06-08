<?php

namespace App\Http\Controllers\PasswordSetup;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowPasswordSetupController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        if ($user->password_set_at !== null) {
            return redirect()->route('login')->withErrors([
                'message' => 'Deze link is al gebruikt. Log in met je e-mailadres en wachtwoord, of vraag een nieuwe link aan via je beheerder.',
            ]);
        }

        return view('passwordSetup.show', [
            'user' => $user,
        ]);
    }
}
