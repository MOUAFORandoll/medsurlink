<?php

namespace App\Http\Controllers\Api\v2\Globale;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Controllers\Controller;
use App\Models\Role;


class RoleController extends Controller
{
    private $roleService;

    /**
     * class RoleController extends Controller
     *
     * @param \App\Services\RoleService $role
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->roleService->index($request));
    }

    /**
     * @param $role
     *
     * @return mixed
     */
    public function show($role)
    {
        return $this->successResponse($this->roleService->show($role));
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());
        return $this->successResponse($this->roleService->store($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $role
     *
     * @return mixed
     */
    public function update(Request $request, $role)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->roleService->update($request, $role));
    }

    public function givePermission($role, $permission)
    {
        if($role->hasPermissionTo($permission)){
            return $this->successResponse($this->roleService->givePermission($role, $permission));
        }
    }

    public function revokePermission($role, $permission)
    {
        if($role->hasPermissionTo($permission)){
            return $this->successResponse($this->roleService->givePermission($role, $permission));
        }
    }

    public function groupesRoles(){
        $roles = Role::where('name', 'Patient')->orWhere('name', 'Souscripteur')->get(['id', 'name']);
        return $this->successResponse($roles);
    }
}