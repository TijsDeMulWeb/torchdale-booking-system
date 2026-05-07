<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        abort_if(auth()->id() !== $id, 403);

        $user->update($request->validated());

        return redirect()->route('profile.show')->with('message', 'Profiel succesvol bijgewerkt.');
    }
}
