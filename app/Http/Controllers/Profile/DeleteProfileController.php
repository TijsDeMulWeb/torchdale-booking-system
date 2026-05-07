<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $user = $request->user();

        abort_if($user->id !== $id, 403);

        $user->delete();

        return redirect()->route('login')->with('message', 'Je account is succesvol verwijderd.');
    }
}
