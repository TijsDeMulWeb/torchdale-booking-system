<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        abort_if(auth()->id() !== $id, 403);

        $user->update([
            'password' => $request->new_password,
        ]);

        return redirect()->route('profile.show')->with('message', 'Je wachtwoord is succesvol gewijzigd.');
    }
}
