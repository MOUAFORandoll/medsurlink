<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationObstetrique;
use App\Models\ConsultationPrenatale;
use App\Models\ExamenClinique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultPrenExamClinController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_obstetriques,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        $consultation = ConsultationPrenatale::find($request->get('consultation'));
        $consultation->examensClinique()->detach($request->get('examensClinique'));

        $consultation = ConsultationPrenatale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));

        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenClinique(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_obstetriques,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

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
        $consultation = ConsultationPrenatale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));

        return response()->json(['consultation'=>$consultation]);
    }
}
