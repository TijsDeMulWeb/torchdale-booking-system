<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\UserInvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ResendUserInvitationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $user = User::where('escaperoom_id', auth()->user()->escaperoom_id)
            ->findOrFail($id);

        if ($user->password_set_at !== null) {
            return redirect()->route('users.index')->with('message', 'Deze gebruiker heeft al een wachtwoord ingesteld.');
        }

        $passwordSetupUrl = URL::temporarySignedRoute(
            'passwordSetup.show',
            now()->addHours(48),
            ['user' => $user->id]
        );

        Mail::to($user->email)->send(new UserInvitationMail($user, $user->escaperoom, $passwordSetupUrl));

        return redirect()->route('users.index')->with('message', 'Uitnodiging opnieuw verstuurd naar ' . $user->email . '.');
    }
}
