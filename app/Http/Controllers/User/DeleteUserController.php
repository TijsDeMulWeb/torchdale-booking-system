<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $usersCount = User::where('escaperoom_id', auth()->user()->escaperoom_id)->count();
        abort_if($user->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        if ($usersCount <= 1) {
            return redirect()->route('users.index')->withErrors(['message' => 'Je kunt de laatste gebruiker niet verwijderen.']);
        }

        if ($user->id === auth()->user()->id) {
            return redirect()->route('users.index')->withErrors(['message' => 'Je kunt jezelf niet verwijderen.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
