<?php

namespace App\Http\Controllers\Api;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::with('feature')->get();
        return response()->json(['permissions' => $permissions]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function permissionFeatureIsNull()
    {
        $permissions = Permission::with('feature')->whereNull('feature_id')->get();
        return response()->json(['permissions' => $permissions]);
    }


    /**
     * Display a listing by group of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupePermission()
    {
        $permissions = Permission::with('feature')->get()->groupBy('feature_id');
        return response()->json(['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assignFeature(Request $request)
    {
        $permissionIds = $request->input('permission_id');
        $featureId = $request->input('feature_id');

        // Récupérer la feature à partir de son ID
        $feature = Feature::findOrFail($featureId);

        // Mettre à jour les permissions avec l'ID de la feature
        $permissions = Permission::whereIn('id', $permissionIds)->update(['feature_id' => $featureId]);

        // Retourner une réponse ou effectuer d'autres actions si nécessaire
        return response()->json(['permissions' => $permissions]);
    }
}
