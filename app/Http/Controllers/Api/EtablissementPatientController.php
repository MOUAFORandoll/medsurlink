<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EtablissementExercice;
use App\Models\EtablissementExercicePatient;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtablissementPatientController extends Controller
{
    public function ajouterPatientAEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            "etablissement"=>'required|integer|exists:etablissement_exercices,id',
            'patient'=>'required|string|exists:patients,slug'
        ]);
        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()->messages()],422);
        }
        $etablissement = EtablissementExercice::find($request->get('etablissement'));
        $patient = Patient::whereSlug($request->get('patient'))->first();

        //Je verifie si ce patient n'est pas encore dans cette etablissement
        $nbre = EtablissementExercicePatient::where('etablissement_id','=',$etablissement)->where('patient_id','=',$patient->user_id)->count();
        if ($nbre ==0){

            $patientSlug = $request->get('patient');
            $patient = Patient::findBySlug($patientSlug);

            $etablissement->patients()->attach($patient->user_id);

            defineAsAuthor("Patient",$patient->user_id,'add to etablissement',$patient->user_id);
        }


        $etablissement = EtablissementExercice::with('patients')->find($etablissement->id);
        return response()->json(['etablissement'=>$etablissement]);
    }

    public function retirerPatientAEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            "etablissement_id"=>'required|integer|exists:etablissement_exercices,id',
            'patient_id'=>'required|integer|exists:patients,user_id'
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()->messages()]);
        }

        $etablissement = EtablissementExercice::find($request->get('etablissement_id'));
        $patient = $request->get('patient_id');
        $etablissement->patients()->detach($patient);

        $etablissement = EtablissementExercice::with('patients')->find($etablissement->id);
        return response()->json(['etablissement'=>$etablissement]);
    }
}
