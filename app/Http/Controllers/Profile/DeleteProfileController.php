<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DeleteProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        abort_if(auth()->id() !== $id, 403);

        $user->forceDelete();

        return redirect()->route('login')->with('message', 'Je account is succesvol verwijderd.');
    }
}
