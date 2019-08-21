<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\ExamenComplementaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultationExamenComplentaireController extends Controller
{
    public function retirerExamenComplementaire(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensComplementaire.*"=>"required|integer|exists:examen_complementaires,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationExamenComplementaire",$consultation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $consultation->examensComplementaire()->detach($request->get('examensComplementaire'));

        $consultation = ConsultationMedecineGenerale::with('examensClinique','examensComplementaire')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenComplementaire(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensComplementaire.*"=>"sometimes|integer|exists:examen_complementaires,id",
            "examensComplementaireACreer.*"=>"sometimes|string|min:2"
        ]);

         if ($validation->fails()){
             return response()->json(['error'=>$validation->errors()],419);
         }
        $examensComplementaire = $request->get('examensComplementaire');
        $examensComplementaireACreer = $request->get('examensComplementaireACreer');

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        if (!is_null($examensComplementaireACreer) or !empty($examensComplementaireACreer)){
            foreach ( $examensComplementaireACreer as $examen)
            {
                $examen = ExamenComplementaire::create([
                    'reference'=>$examen
                ]);
                $consultation->examensComplementaire()->attach($examen->id);
            }
        }

        if (!is_null($examensComplementaire) or !empty($examensComplementaire)){
            $consultation->examensComplementaire()->attach($examensComplementaire);
        }

        defineAsAuthor("ConsultationExamenComplementaire",$consultation->id,'attach');
        $consultation = ConsultationMedecineGenerale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
