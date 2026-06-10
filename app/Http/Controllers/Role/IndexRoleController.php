<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class IndexRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();

        return view('role.index', compact('roles'));
    }
}
