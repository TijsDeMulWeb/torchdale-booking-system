<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UpdateUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        abort_if($user->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $user->update($request->validated());

        return redirect()->route('users.index')->with('message', 'Gebruiker succesvol bijgewerkt.');
    }
}
