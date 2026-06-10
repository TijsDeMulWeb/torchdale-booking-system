<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class DeleteRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role)
    {
        abort_if($role->name === 'Admin', 403, 'De Admin-rol kan niet verwijderd worden.');
        abort_if($role->users()->exists(), 422, 'Deze rol is nog aan gebruikers toegewezen.');

        $role->delete();

        return redirect()->route('roles.index')->with('message', 'Rol succesvol verwijderd.');
    }
}
