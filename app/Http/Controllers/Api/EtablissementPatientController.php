<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EtablissementExercice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EtablissementPatientController extends Controller
{
    public function ajouterPatientAEtablissement(Request $request){
        $validation = Validator::make($request->all(),[
            "etablissement_id"=>'required|integer|exists:etablissement_exercices,id',
            'patients.*'=>'required|integer|exists:patients,user_id'
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()->messages()]);
        }

        $etablissement = EtablissementExercice::find($request->get('etablissement_id'));
        $patients = $request->get('patients');
        $etablissement->patients()->attach($patients);

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
