<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\UserInvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class StoreUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request)
    {
        $escaperoom = auth()->user()->escaperoom;

        $user = new User();
        $user->fill($request->validated());
        $user->escaperoom_id = $escaperoom->id;
        $user->password = Str::random(40);
        $user->save();

        User::find($user->id)->assignRole('admin');

        $passwordSetupUrl = URL::temporarySignedRoute(
            'passwordSetup.show',
            now()->addHours(48),
            ['user' => $user->id]
        );

        Mail::to($user->email)->send(new UserInvitationMail($user, $escaperoom, $passwordSetupUrl));

        return redirect()->route('users.index')->with('message', 'Gebruiker succesvol aangemaakt.');
    }
}
