<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class EditRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role)
    {
        $permissionGroups = config('permissions');
        $rolePermissions = $role->permissions->pluck('name')->all();

        return view('role.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }
}
