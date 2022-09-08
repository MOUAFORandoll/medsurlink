<?php

namespace App\Http\Controllers\Api;

use App\Models\ActivitesControle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\DelaiOperation;
use App\Models\DossierMedical;
use Illuminate\Support\Facades\Auth;

class ActivitesControleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activitesmed = ActivitesControle::with('createur','ActivitesMedecinReferent')->get();
        return  response()->json(['activitesmed'=>$activitesmed]);
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
        $request->validate([
            'commentaire'=>'string|nullable',
            'activite_id'=>'integer|required'
        ]);

        $activity = ActivitesControle::where("patient_id", $request->patient_id)->latest()->first();
        $affiliation = Affiliation::where("patient_id", $request->patient_id)->latest()->first();
        $delai_operation = DelaiOperation::where("patient_id", $request->patient_id)->latest()->first();
        $dossier = DossierMedical::where('patient_id', $request->patient_id)->latest()->first();

        $activite = ActivitesControle::create([
            "activite_id" => $request->activite_id,
            "patient_id" => $request->patient_id,
            'etablissement_id' => $request->etablissement_id,
            'affiliation_id' => $request->affiliation_id,
            'ligne_temps_id' => $request->ligne_temps_id,
            "creator" => auth()->user()->id,
            "commentaire" => $request->commentaire,
            "statut" => $request->statut,
            "date_cloture" => $request->date_cloture
        ]);

        if(!is_null($delai_operation)){
            DelaiOperation::create(
                [
                    "patient_id" => $request->patient_id,
                    "delai_operationable_id" => $activite->id,
                    "delai_operationable_type" => ActivitesControle::class,
                    "date_heure_prevue" => $delai_operation->created_at,
                    "date_heure_effectif" => $activite->created_at,
                    "observation" => "RAS"
                ]
            );
        }
        elseif(!is_null($activity)){
            DelaiOperation::create(
                [
                    "patient_id" => $request->patient_id,
                    "delai_operationable_id" => $activite->id,
                    "delai_operationable_type" => ActivitesControle::class,
                    "date_heure_prevue" => $activity->created_at,
                    "date_heure_effectif" => $activite->created_at,
                    "observation" => "RAS"
                ]
            );
        }elseif(!is_null($affiliation)){
            DelaiOperation::create(
                [
                    "patient_id" => $request->patient_id,
                    "delai_operationable_id" => $activite->id,
                    "delai_operationable_type" => ActivitesControle::class,
                    "date_heure_prevue" => $affiliation->updated_at,
                    "date_heure_effectif" => $activite->created_at,
                    "observation" => "RAS"
                ]
            );
        }elseif(!is_null($dossier)){
            DelaiOperation::create(
                [
                    "patient_id" => $request->patient_id,
                    "delai_operationable_id" => $activite->id,
                    "delai_operationable_type" => ActivitesControle::class,
                    "date_heure_prevue" => $dossier->updated_at,
                    "date_heure_effectif" => $activite->created_at,
                    "observation" => "RAS"
                ]
            );
        }

        
        // $med = new ActivitesControle;
        // $med->creator = Auth::id();
        // $med->activite_id = $request->activite_id;
        // $med->etablissement_id = $request->etablissement_id;
        // $med->ligne_temps_id = $request->ligne_temps_id;
        // $med->patient_id = $request->patient_id;
        // $med->statut = $request->statut;
        // $med->commentaire = $request->commentaire;
        // $med->date_cloture = $request->date_cloture;
        // $med->save();

        return response()->json(['medReferent' => $activite]);
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
}
