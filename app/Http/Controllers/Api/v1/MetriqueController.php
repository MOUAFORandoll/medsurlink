<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Metrique;
use Illuminate\Support\Carbon;

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
        /**
         * Filtrage par mois
         */
        $today = Carbon::now()->format('Y-m-d');
        $date = Carbon::now()->subDays(30)->format('Y-m-d');
        
        $nbre_patients = Metrique::semaineMoisAnnee($date, $today)->get(['nbre_patients', 'created_at']);
        $temps_moyen = Metrique::semaineMoisAnnee($date, $today)->get(['temps_moyen', 'created_at']);
        $affiliation_et_affectation_medecin_referents = Metrique::semaineMoisAnnee($date, $today)->get(['affiliation_et_affectation_medecin_referents', 'created_at']);
        $consultation_medecine_generale = Metrique::semaineMoisAnnee($date, $today)->get(['consultation_medecine_generale', 'created_at']);
        $consultation_fichier = Metrique::semaineMoisAnnee($date, $today)->get(['consultation_fichier', 'created_at']);
        $resultat_labo = Metrique::semaineMoisAnnee($date, $today)->get(['resultat_labo', 'created_at']);
        $resultat_imagerie = Metrique::semaineMoisAnnee($date, $today)->get(['resultat_imagerie', 'created_at']);
        $avis_medicals = Metrique::semaineMoisAnnee($date, $today)->get(['avis_medicals', 'created_at']);
        $medecin_controle = Metrique::semaineMoisAnnee($date, $today)->get(['medecin_controle', 'created_at']);
        $consultation_examen_validation = Metrique::semaineMoisAnnee($date, $today)->get(['consultation_examen_validation', 'created_at']);
        $activite_amas = Metrique::semaineMoisAnnee($date, $today)->get(['activite_amas', 'created_at']);

        
        return response()->json([
            'nbre_patients' => $nbre_patients,
            'temps_moyen' => $temps_moyen,
            'affiliation_et_affectation_medecin_referents' => $affiliation_et_affectation_medecin_referents,
            'consultation_medecine_generale' => $consultation_medecine_generale,
            'consultation_fichier' => $consultation_fichier,
            'resultat_labo' => $resultat_labo,
            'resultat_imagerie' => $resultat_imagerie,
            'avis_medicals' => $avis_medicals,
            'medecin_controle' => $medecin_controle,
            'consultation_examen_validation' => $consultation_examen_validation,
            'activite_amas' => $activite_amas
        ]);
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
