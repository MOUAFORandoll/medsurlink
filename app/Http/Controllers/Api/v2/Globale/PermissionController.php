<?php

namespace App\Http\Controllers\Api\v2\Globale;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    private $permissionService;

    /**
     * class PermissionController extends Controller
     *
     * @param \App\Services\PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->successResponse($this->permissionService->index($request));
    }

    /**
     * @param $permission
     *
     * @return mixed
     */
    public function show($permission)
    {
        return $this->successResponse($this->permissionService->show($permission));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validations());
        return $this->successResponse($this->permissionService->store($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $permission
     *
     * @return mixed
     */
    public function update(Request $request, $permission)
    {
        $this->validate($request, $this->validations(true));
        return $this->successResponse($this->permissionService->update($request, $permission));
    }

    public function assignRole(Request $request, $permission){
        return $this->successResponse($this->permissionService->assignRole($request, $permission));
    }

    public function removeRole($permission, $role){
        return $this->successResponse($this->permissionService->removeRole($role, $permission));
    }

    /**
     * @param $permission
     *
     * @return mixed
     */
    public function destroy($permission)
    {
        return $this->successResponse($this->permissionService->destroy($permission));
    }

    public function validations($is_update = false){
        if($is_update){
            $rules = [
                'name' => 'required',
            ];
        }else{
            $rules = [
                'name' => 'required',
            ];
        }
        return $rules;
    }
}
