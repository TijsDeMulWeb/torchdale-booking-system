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
        abort_if($user->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $user->delete();
    }
}
