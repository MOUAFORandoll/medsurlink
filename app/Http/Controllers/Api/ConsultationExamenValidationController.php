<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConsultationExamenValidation;

class ConsultationExamenValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examen_validation = ConsultationExamenValidation::with(['examenComplementaire','otherExamenComplementaire','etablissement'])->get();
        return response()->json(['examen_validation'=>$examen_validation]);
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
        $examen_validation =  ConsultationExamenValidation::create([
            'souscripteur_id'=>$request->get('souscripteur_id'),
            'examen_complementaire_id'=>$request->get('examen_complementaire_id'),
            'medecin_id'=>$request->get('medecin_id'),
            'medecin_control_id'=>$request->get('medecin_control_id'),
            'ligne_de_temps_id'=>$request->get('ligne_de_temps_id'),
            'etat_validation_medecin'=>$request->get('etat_validation_medecin'),
            'etat_validation_souscripteur'=>$request->get('etat_validation_souscripteur'),
            'date_validation_medecin'=>$request->get('date_validation_medecin'),
            'date_validation_souscripteur'=>$request->get('date_validation_souscripteur'),
        ]);

        return  response()->json(['examen_validation'=>$examen_validation]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examen_validation = ConsultationExamenValidation::whereId($id)->with(['examenComplementaire','otherExamenComplementaire','etablissement'])->first();
        return response()->json(['examen_validation'=>$examen_validation]);
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
