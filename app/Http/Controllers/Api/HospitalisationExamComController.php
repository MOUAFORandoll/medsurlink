<?php

namespace App\Http\Controllers\Api;

use App\Models\ExamenComplementaire;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HospitalisationExamComController extends Controller
{
    public function retirerExamenComplementaire(Request $request){
        $validation = Validator::make($request->all(),[
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensComplementaire.*"=>"required|integer|exists:examen_complementaires,id"
        ]);

        if ($validation->fails())
            return response()->json(['error'=>$validation->errors()],419);


        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("HospitalisationExamCom",$hospitalisation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 ); }


        $hospitalisation->examensComplementaire()->detach($request->get('examensComplementaire'));

        $hospitalisation = Hospitalisation::with(['examensClinique','examensComplementaire'])->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    public function ajouterExamenComplementaire(Request $request){

        $validation = Validator::make($request->all(),[
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensComplementaire.*"=>"sometimes|integer|exists:examen_complementaires,id",
            "examensComplementaireACreer.*"=>"sometimes|string|min:2"
        ]);

        if ($validation->fails())
            return response()->json(['error'=>$validation->errors()],419);


        $examensComplementaire = $request->get('examensComplementaire');
        $examensComplementaireACreer = $request->get('examensComplementaireACreer');

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));

        if (!is_null($examensComplementaireACreer) or !empty($examensComplementaireACreer)){
            foreach ( $examensComplementaireACreer as $examen)
            {
                $examen = ExamenComplementaire::create([
                    'reference'=>$examen
                ]);
                $hospitalisation->examensComplementaire()->attach($examen->id);
            }
        }

        if (!is_null($examensComplementaire) or !empty($examensComplementaire)){
            $hospitalisation->examensComplementaire()->attach($examensComplementaire);
        }

        defineAsAuthor("HospitalisationExamCom",$hospitalisation->id,'attach');

        $hospitalisation = Hospitalisation::with(['examensClinique','examensComplementaire'])->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }
}
