<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivitesMedecinReferent;

class ActivitesMedecinReferentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medref = ActivitesMedecinReferent::with('etablissements','user')->get();
        return  response()->json([
            'pec' => $medref,
        ]);
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

    public function getListActivites(){
        $mission = ActivitesMedecinReferent::where('type','MANUELLE')->get();
        return response()->json(['activites'=>$mission]);
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
     * @param  \App\ActivitesMedecinReferent  $activitesMedecinReferent
     * @return \Illuminate\Http\Response
     */
    public function show(ActivitesMedecinReferent $activitesMedecinReferent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActivitesMedecinReferent  $activitesMedecinReferent
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivitesMedecinReferent $activitesMedecinReferent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActivitesMedecinReferent  $activitesMedecinReferent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivitesMedecinReferent $activitesMedecinReferent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActivitesMedecinReferent  $activitesMedecinReferent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivitesMedecinReferent $activitesMedecinReferent)
    {
        //
    }
}
