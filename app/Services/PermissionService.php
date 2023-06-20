<?php

namespace App\Services;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public  $user_id, $user;

    public function __construct()
    {
        $this->user_id = \Auth::guard('api')->user()->id;
        $this->user = \Auth::guard('api')->user();
    }
    public function index(Request $request){
        $permissions = Permission::all();
        return $permissions;
    }

    public function store(Request $request){
        $permission = $request->validate(['name' => 'required']);
        Permission::create($permission);
        return $permission;
    }
    
    public function show(Permission $permission){

    }

    public function update(Request $request, Permission $permission){
        $permission = $request->validate(['name' => 'required']);
        $permission->update($permission);
        return $permission;
    }

    public function assignRole(Request $request, Permission $permission){
        if ($permission->hasRole($request->role)) {
            return $permission;
        }

        $permission->assignRole($request->role);
        return $permission;
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return $permission;
        }
        return $permission;
    }

    public function destroy($permission){
        $permission = Permission::findOrFail($permission);
        $permission->delete();
        return $permission;
    }

}
