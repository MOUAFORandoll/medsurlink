
<?php

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
// namespace App\Services;



class RoleService
{
    public  $user_id, $user;

    public function __construct()
    {
        $this->user_id = \Auth::guard('api')->user()->id;
        $this->user = \Auth::guard('api')->user();
    }

    public function index()
    {
        $roles = Role::all();
        return  $roles;
    }

    public function create()
    {
        // Create role
    }

    public function store(Request $request)
    {
        $role = $request->validate(['name' => ['required', 'min:3']]);
        Role::create($role);
        return $role;
    }

    public function edit()
    {
        // Edit role
    }

    public function update(Request $request, Role $role)
    {
        $role = $request->validate(['name' => ['required', 'min:3']]);
        $role->update($role);

        return $role;
    }

    public function destroy(Role $role)
    {
        $role = Role::findOrFail($role);
        $role->delete();
        return $role;
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){
            $role->givePermissionTo($request->permission);
            return $role;
        }
        return $role;
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            return $role;
        }
        return $role;
    }

}