<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\ExamenClinique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultationExamenCliniqueController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationExamenClinique",$consultation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            $transmission = [];
            $transmission['accessRefuse'][0] = "Vous ne pouvez modifié un élement que vous n'avez crée";
            return response()->json(['error'=>$transmission],419 );  }

        $consultation->examensClinique()->detach($request->get('examensClinique'));

        $consultation = ConsultationMedecineGenerale::with('examensClinique')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $examensClinique = $request->get('examensClinique');
        $examensCliniqueACreer = $request->get('examensCliniqueACreer');

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

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

        defineAsAuthor("ConsultationExamenClinique",$consultation->id,'attach');
        $consultation = ConsultationMedecineGenerale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
