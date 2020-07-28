<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PersonnalErrors;
use App\Http\Requests\EtablissementExerciceRequest;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExerciceMedecin;
use App\Models\EtablissementExercicePatient;
use App\Models\EtablissementExercicePraticien;
use App\Models\Patient;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Netpok\Database\Support\DeleteRestrictionException;

/**
 * Class EtablissementExerciceController
 * @package App\Http\Controllers\Api
 */
class EtablissementExerciceController extends Controller
{
    use PersonnalErrors;
    protected $table = "etablissement_exercices";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etablissements =  EtablissementExercice::with(['praticiens','patients.dossier','patients.user','patients.financeurs','prestations'])->get();
        return response()->json(['etablissements'=>$etablissements]);


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
    public function store(EtablissementExerciceRequest $request)
    {
        $etablissement = EtablissementExercice::create([
            "name"=> strtoupper($request->name),
            "description"=>$request->description,
            "adresse"=>$request->get('adresse')
        ]);

        if($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $path = $request->logo->store('public/Etablissement/' . $etablissement->slug.'/Logo');
                $file = str_replace('public/','',$path);

                $etablissement->logo = $file;

                $etablissement->save();
            }
        }

        defineAsAuthor("EtablissementExercice",$etablissement->id,'create');

        return response()->json(['etablissement'=>$etablissement]);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function show($slug)
    {
        $this->validatedSlug($slug,$this->table);

        $etablissement = EtablissementExercice::with(['praticiens','patients.dossier','patients.user','prestations.prestation'])->whereSlug($slug)->first();

        return response()->json(['etablissement'=>$etablissement]);


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
     * @param EtablissementExerciceRequest $request
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(EtablissementExerciceRequest $request, $slug)
    {
        $this->validatedSlug($slug,$this->table);

        EtablissementExercice::whereSlug($slug)->update([
            "name"=> strtoupper($request->name),
            "description"=>$request->description,
            "adresse"=>$request->get('adresse')
        ]);

        $etablissement = EtablissementExercice::with(['praticiens','patients'])->whereSlug($slug)->first();

        $logo = $etablissement->logo;

        if($request->hasFile('logo')){
            if ($request->file('logo')->isValid()) {
                $path = $request->logo->store('public/Etablissement/' . $etablissement->slug.'/Logo');
                $file = str_replace('public/','',$path);

                $etablissement->logo = $file;

                $etablissement->save();


                if (!is_null($logo)){
                    //Suppression de l'ancienne sur server
                    File::delete(public_path().'/storage/'.$logo);
                }
            }
        }else{
            $etablissement->logo = '';
            $etablissement->save();
        }



        return response()->json(['etablissement'=>$etablissement]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy($slug)
    {
        $this->validatedSlug($slug,$this->table);

        try{
            $etablissement = EtablissementExercice::with(['praticiens','patients'])->whereSlug($slug)->first();
            $etablissement->delete();
            return response()->json(['etablissement'=>$etablissement]);

        }catch (DeleteRestrictionException $deleteRestrictionException){
            $this->revealError('deletingError',$deleteRestrictionException->getMessage());
        }
    }

    public function userEtablissements(){
        $user = Auth::user();
        $userRoles = $user->getRoleNames();

        if(gettype($userRoles->search('Praticien')) == 'integer'){
            $user = \App\User::with(['praticien'])->whereId(Auth::id())->first();
            //Recuperation des etablissements du praticien
            if (!is_null($user->praticien)){
                $etablissements = EtablissementExercicePraticien::where('praticien_id','=',Auth::id())->get();
                $etablissementsId = [];
                foreach ($etablissements as $etablissement){
                    if (!is_null($etablissement))
                    {
                        array_push($etablissementsId, $etablissement->etablissement_id);
                    }
                }
                $etablissements = EtablissementExercice::with(['patients','prestations'])->whereIn('id',$etablissementsId)->get();
                return response()->json(['etablissements'=>$etablissements]);
            }
        }
        else if(gettype($userRoles->search('Medecin controle')) == 'integer'){
            $user = \App\User::with(['medecinControle'])->whereId(Auth::id())->first();
            //Recuperation des etablissements du medecin controle
            if (!is_null($user->medecinControle)){
//                $etablissements = EtablissementExerciceMedecin::where('medecin_controle_id','=',Auth::id())->get();
                $etablissements = EtablissementExercice::all();
                $etablissementsId = [];
                foreach ($etablissements as $etablissement){
                    if (!is_null($etablissement))
                    {
                        array_push($etablissementsId, $etablissement->id);
                    }
                }
                $etablissements = EtablissementExercice::with(['patients.user','patients.dossier','prestations.prestation','factures.dossier.patient.user'])->whereIn('id',$etablissementsId)->get();
                return response()->json(['etablissements'=>$etablissements]);
            }
        }
        else if(gettype($userRoles->search('Patient')) == 'integer'){
            $user = \App\User::with(['patient'])->whereId(Auth::id())->first();
            //Recuperation des etablissements du patient
            if (!is_null($user->patient)){
                $etablissements = EtablissementExercicePatient::where('patient_id','=',Auth::id())->get();
                $etablissementsId = [];

                foreach ($etablissements as $etablissement){
                    if (!is_null($etablissement)){
                        array_push($etablissementsId, $etablissement->etablissement_id);
                    }
                }
                $etablissements = EtablissementExercice::whereIn('id',$etablissementsId)->get();
                return response()->json(['etablissements'=>$etablissements]);
            }
        }
        else if(gettype($userRoles->search('Gestionnaire')) == 'integer'){
            $etablissements = EtablissementExercice::with(['patients.user','prestations.prestation','factures.dossier.patient.user'])->get();

            return response()->json(['etablissements'=>$etablissements]);

        }
        else{
            return response()->json(['etablissements'=>[]]);

        }
    }
}
