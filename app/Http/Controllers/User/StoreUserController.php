<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class StoreUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request)
    {
        $user = new User();
        $user->fill($request->validated());
        $user->escaperoom_id = auth()->user()->escaperoom_id;
        $user->password = auth()->user()->escaperoom->name;
        $user->save();

        return redirect()->route('users.index')->with('message', 'Gebruiker succesvol aangemaakt.');
    }
}
