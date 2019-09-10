<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationObstetrique;
use App\Models\ConsultationPrenatale;
use App\Models\ExamenClinique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultPrenExamClinController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_prenatales,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationPrenatale::find($request->get('consultation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultPrenExamClin",$consultation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $consultation->examensClinique()->detach($request->get('examensClinique'));

        $consultation = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique','examensClinique','examensComplementaire'])->find($request->get('consultation'));

        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_prenatales,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $examensClinique = $request->get('examensClinique');
        $examensCliniqueACreer = $request->get('examensCliniqueACreer');

        $consultation = ConsultationPrenatale::find($request->get('consultation'));

        if (!is_null($examensCliniqueACreer) or !empty($examensCliniqueACreer)){
            foreach ( $examensCliniqueACreer as $examen)
            {
                $examen = ExamenClinique::create([
                    'reference'=>$examen
                ]);
                $consultation->examensClinique()->attach($examen->id);
            }
        }

        if (!is_null($examensClinique) or !empty($examensClinique)){
            $consultation->examensClinique()->attach($examensClinique);
        }

        defineAsAuthor("ConsultPrenExamClin",$consultation->id,'attach');
        $consultation = ConsultationPrenatale::with(['consultationObstetrique','parametresObstetrique','examensClinique','examensComplementaire'])->find($request->get('consultation'));

        return response()->json(['consultation'=>$consultation]);
    }
}
