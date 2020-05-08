<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SuiviRequest;
use App\Models\SpecialiteSuivi;
use App\Models\Suivi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    use PersonnalErrors;
    protected $table = 'suivis';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suivis = Suivi::with('dossier.patient.user','responsable','specialites.specialite')->get();

        return  response()->json(['suivis'=>$suivis]);

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
    public function store(SuiviRequest $request)
    {
        //Creation du suivi principal
        $suivi = Suivi::create($request->except('specialite') );

        //Récupération de la liste des suivi par spécialité
        $specialites = $request->only('specialite');

        foreach ($specialites as $specialite){
            //Création des suivis par spécialité
            SpecialiteSuivi::create($specialite[0] + ['suivi_id'=>$suivi->id]);
        }

        $suivi = Suivi::with('dossier.patient.user','responsable','specialites.specialite')->find($suivi->id);

        return  response()->json(['suivi'=>$suivi]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $suivi = Suivi::with('dossier.patient.user','responsable','specialites.specialite')
            ->whereSlug($slug)->first();

        return  response()->json(['suivi'=>$suivi]);
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(SuiviRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

//        Ici on modifit uniquement le suivi principal, si on désire modifie le suivi d'une spécialité on modifiera
//        ce suivi là à part

        Suivi::whereSlug($slug)->update($request->only("dossier_medical_id", "responsable", "motifs", "etat"));

        $suivi = Suivi::whereSlug($slug)->first();

        return  response()->json(['suivi'=>$suivi]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $suivi = Suivi::whereSlug($slug)->first();

        $suivi->delete();

        return  response()->json(['suivi'=>$suivi]);


    }
}
