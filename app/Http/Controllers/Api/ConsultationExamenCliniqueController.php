<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\ExamenClinique;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationExamenCliniqueController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));
        $consultation->examensClinique()->detach($request->get('examensClinique'));

        $consultation = ConsultationMedecineGenerale::with('examensClinique')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenClinique(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

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


        $consultation = ConsultationMedecineGenerale::with('examensClinique')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
