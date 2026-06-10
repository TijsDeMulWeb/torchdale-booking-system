<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Spatie\Permission\Models\Role;

class StoreRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->validated('name')]);
        $role->syncPermissions($request->validated('permissions', []));

        return redirect()->route('roles.index')->with('message', 'Rol succesvol aangemaakt.');
    }
}
