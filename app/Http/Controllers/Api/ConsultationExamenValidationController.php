<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationMedecineGenerale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConsultationExamenValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_medecin')
        ->distinct()
        ->get(['consultation_general_id']);
        return response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListExamenToValidate($slug)
    {
        $consultation = ConsultationMedecineGenerale::whereSlug($slug)->first();
        $etablissement = $consultation->etablissement_id;
        $examen_validation = ConsultationExamenValidation::with(['consultation.dossier.patient.user','examenComplementaire','etablissement','examenComplementaire.examenComplementairePrix' => function ($query) use ($etablissement) {
            $query->where('etablissement_exercices_id', '=', $etablissement);
        }])->where('consultation_general_id', '=', $consultation->id)->get();
        return response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExamenValidationSouscripteur()
    {
        //$examen_validation = ConsultationExamenValidation::with(['examenComplementaire'])->where('souscripteur_id', '=',Auth::id())->get();
        //return response()->json(['examen_validation'=>$examen_validation]);
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_souscripteur')
        ->where('souscripteur_id', '=',Auth::id())
        ->distinct()
        ->get(['consultation_general_id']);
        return response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Count nomber of validation.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountInvalidation()
    {
        $examen_validation = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //->whereNull('etat_validation_medecin')
        ->distinct()
        ->get(['consultation_general_id']);;
        return response()->json(['examen_validation'=>$examen_validation->count()]);
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
            'version'=>1
        ]);

        return  response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Update medecin validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEtatValidationMedecin(Request $request)
    {
       // dd($request->get('examens'));
        $examen_validation = ConsultationExamenValidation::whereIn('id',$request->get('examens'))->get();
        foreach($examen_validation as $examen){
            $examen->etat_validation_medecin = 1;
            $examen->medecin_control_id = Auth::id();
            $examen->date_validation_medecin = Carbon::now();
            $examen->save();
        }
        ConsultationExamenValidation::whereNotIn('id',$request->get('examens'))
        ->update([
            'etat_validation_medecin' => 0,
        ]);
        return  response()->json(['examen_validation'=>$examen_validation]);
    }
    /**
     * Update medecin validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEtatValidationSouscripteur(Request $request)
    {

        $examens = $request->get('examens');
        $examens_id = array_column($examens, 'id');
        if(count($examens) > 0){
            $examen_validation = ConsultationExamenValidation::where("consultation_general_id",$examens[0]['consultation'])->get();
            foreach($examen_validation as $examen){
                if(in_array($examen->id, $examens_id)){
                    $examen->etat_validation_souscripteur = 1;
                    $examen->version = $examen->version+1;
                    $examen->date_validation_souscripteur = Carbon::now();
                    $examen->save();
                }else{
                    $examen->etat_validation_souscripteur = 0;
                    $examen->version = $examen->version+1;
                    $examen->date_validation_souscripteur = Carbon::now();
                    $examen->save();
                }
            }
        }
        return  response()->json(['examen_validation'=>true]);
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
