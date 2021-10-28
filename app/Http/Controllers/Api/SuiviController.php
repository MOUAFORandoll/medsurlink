<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\SuiviRequest;
use App\Models\MedecinDeSuivi;
use App\Models\SpecialiteSuivi;
use App\Models\Suivi;
use App\Models\SuiviToDoList;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;

    protected $table = 'suivis';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suivis = Suivi::with('toDoList','categorie','dossier.patient.user','responsable.praticien','specialites.specialite')->get();

        return  response()->json(['suivis'=>$suivis]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($value)
    {
        $result=[];
        $suivis = Suivi::with('toDoList','categorie','dossier.patient.user','responsable.praticien','specialites.specialite')->get();
        foreach($suivis as $p){
            if($p->dossier != null && $p->dossier->patient->user != null){
                if( 
            strpos(strtolower($p->dossier->patient->user->prenom),strtolower($value)) || 
            strpos(strtolower(strval($p->dossier->patient->user->nom)),strtolower($value))) 
            array_push($result,$p);
            }
            else{
                if(strpos(strtolower($p->motifs),strtolower($value))) 
                array_push($result,$p);
            }
            
        }

        return  response()->json(['suivis'=>$result]);


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
        $suivi = Suivi::create($request->except('specialite','toDoList') );

        //Récupération de la liste des suivi par spécialité
        if ($request->has('specialite')){
            $specialites = $request->only('specialite');
            if (!is_null($specialites)){
                if (gettype($specialites['specialite']) == 'array') {
                    foreach ($specialites['specialite'] as $specialite) {
                        if (!empty($specialite)) {
                            //Création des suivis par spécialité
                            SpecialiteSuivi::create($specialite + ['suivi_id' => $suivi->id]);
                        }
                    }
                }
            }
        }
        if ($request->has('toDoList')) {
            $toDoLists = $request->only('toDoList');
            if (!is_null($toDoLists)) {
                if (gettype($toDoLists['toDoList']) == 'array'){
                    foreach ($toDoLists['toDoList'] as $toDoList) {
                        if (!empty($toDoList)) {
                            //Création des suivis par spécialité
                            SuiviToDoList::create($toDoList + ['listable_id' => $suivi->id, 'listable_type' => 'Suivi']);
                        }
                    }
                }
            }
        }

        if ($request->has('responsable')) {
            $praticiens = $request->only('responsable');
            if (!is_null($praticiens)) {
                if (gettype($praticiens['responsable']) == 'array'){
                    foreach ($praticiens['responsable'] as $praticien) {
                        if (!empty($praticien)) {
                            //Création des suivis par spécialité
                            MedecinDeSuivi::create(['user_id'=>$praticien['id'],'suivi_id'=>$suivi->id]);
                        }
                    }
                }
            }
        }

        $suivi = Suivi::with('toDoList','categorie','dossier.patient.user','responsable.praticien','specialites.specialite')->find($suivi->id);
        $this->updateDossierId($suivi->dossier->id);
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

        $suivi = Suivi::with('toDoList','categorie','dossier.patient.user','responsable.praticien','specialites.specialite')
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

        Suivi::whereSlug($slug)->update($request->only("dossier_medical_id", "motifs", "etat","categorie_id"));

        $suivi = Suivi::with('responsable')->whereSlug($slug)->first();
        $nouveauPraticiens = [];
        if ($request->has('responsable')) {
            $praticiens = $request->only('responsable');
            if (!is_null($praticiens)) {
                if (gettype($praticiens['responsable']) == 'array'){
                    foreach ($praticiens['responsable'] as $praticien){
                        array_push($nouveauPraticiens,$praticien['id']);
                    }


                    foreach ( $suivi->responsable as $praticien) {
                        if (!in_array($praticien->user_id,$nouveauPraticiens)){
                            $medecin = MedecinDeSuivi::whereId($praticien->id)->first();
                            $medecin->delete();
                        }
                    }


                    foreach ($praticiens['responsable'] as $praticien) {
                        if (!empty($praticien)) {
                            if (!in_array($praticien['id'],(($suivi->responsable)->pluck('user_id'))->toArray())){
                                 MedecinDeSuivi::create(['user_id'=>$praticien['id'],'suivi_id'=>$suivi->id]);
                             }
                        }
                    }

                }
            }
        }

        $suivi = Suivi::with('toDoList','categorie','dossier.patient.user','responsable.praticien','specialites.specialite')->find($suivi->id);
        $this->updateDossierId($suivi->dossier->id);

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

        if (!is_null($suivi)){
            $this->updateDossierId($suivi->dossier->id);
            $suivi->delete();
        }

        return  response()->json(['suivi'=>$suivi]);


    }
}
