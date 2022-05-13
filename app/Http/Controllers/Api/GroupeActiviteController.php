<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Activite;
use App\Models\GroupeActivite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupeActiviteController extends Controller
{
    use PersonnalErrors;
    public $table = 'groupe_activites';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activites = GroupeActivite::with('missions')->latest()->get();
        return response()->json(['activites'=>$activites]);
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,'groupe_activites');
        $groupe = GroupeActivite::with('missions')->whereSlug($slug)->first();
//        $activites = Activite::where('groupe_activite',$groupe->nom)->latest()->get();
        return response()->json(['groupe'=>$groupe]);
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
}
