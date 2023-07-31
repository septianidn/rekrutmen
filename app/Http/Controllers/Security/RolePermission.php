<?php

namespace App\Http\Controllers\Security;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermission extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::get();
        $permissions = Permission::get();
        return view('role-permission.permissions', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $inputPermissions = $request->input('permission');
    
        $allPermissions = Permission::all();
    
        foreach ($allPermissions as $permission) {
            // Cek apakah permission terdapat dalam input data checkbox
            if (isset($inputPermissions[$permission->name])) {
                // Jika tercentang, berikan permission ke role
                foreach ($inputPermissions[$permission->name] as $roleName => $value) {
                    $role = Role::where('name', $roleName)->first();
                    if ($value) {
                        $role->givePermissionTo($permission);
                    }
                }
            } else {
                // Jika tidak tercentang, hapus permission dari role
                $rolesWithPermission = $permission->roles;
                foreach ($rolesWithPermission as $role) {
                    $role->revokePermissionTo($permission);
                }
            }
        }
    
        return redirect()->route('role-permission.index')->withSuccess(__('message.permissions_msg_updated'));
    }
    
}
