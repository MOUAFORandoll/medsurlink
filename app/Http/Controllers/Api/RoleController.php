<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->get('name'),
            'guard_name' => 'api'
        ]);

        //        $permission = Permission::create(['name'=>$request->get('permission'),]);
        return response()->json(['role' => $role]);
    }

    function assignPermission(Request $request)
    {
        $roleId = $request->get('roleId');
        $permissionIds = $request->get('permissionIds');
        $role = Role::find($roleId);
        $role->permissions()->sync($permissionIds);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with('permissions')->where('id', $id)->first();
        return response()->json(['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id)->update([
            'name' => $request->get('name'),
            'guard_name	' => "api"
        ]);
        return response()->json(['role' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        $role->delete();
        return response()->json(['delete' => "Utilisateur supprimé avec succes"]);
    }
}
