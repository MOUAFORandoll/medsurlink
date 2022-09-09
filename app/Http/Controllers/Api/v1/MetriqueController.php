<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metrique = RecuperationMetrique();
        return response()->json([
            "temps_moyen" => ConversionDesDelais($metrique->temps_moyen), 
            'nbre_patients' => $metrique->nbre_patients, 
            'affiliation_et_affectation_medecin_referents' => ConversionDesDelais($metrique->affiliation_et_affectation_medecin_referents),
            'consultation_medecine_generale' => ConversionDesDelais($metrique->consultation_medecine_generale),
            'consultation_fichier' => ConversionDesDelais($metrique->consultation_fichier),
            'resultat_labo' => ConversionDesDelais($metrique->resultat_labo),
            'resultat_imagerie' => ConversionDesDelais($metrique->resultat_imagerie),
            'avis_medicals' => ConversionDesDelais($metrique->avis_medicals),
            'medecin_controle' => ConversionDesDelais($metrique->medecin_controle),
            'consultation_examen_validation' => ConversionDesDelais($metrique->consultation_examen_validation),
            'activite_amas' => ConversionDesDelais($metrique->activite_amas),
            'date_recuperation' => $metrique->date_recuperation
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['id' => $id]);
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
}
