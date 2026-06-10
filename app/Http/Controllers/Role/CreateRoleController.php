<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;

class CreateRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $permissionGroups = config('permissions');

        return view('role.create', compact('permissionGroups'));
    }
}
