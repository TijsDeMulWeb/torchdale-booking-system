<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\StoreUserController;
use App\Models\User;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserController $request, int $id)
    {
        $user = User::findOrFail($id);

        abort_if(auth()->id() !== $id, 403);
    }
}
