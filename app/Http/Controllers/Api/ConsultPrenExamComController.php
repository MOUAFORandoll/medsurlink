<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationPrenatale;
use App\Models\ExamenClinique;
use App\Models\ExamenComplementaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultPrenExamComController extends Controller
{
    public function retirerExamenComplementaire(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_obstetriques,id",
            "examensComplementaire.*"=>"required|integer|exists:examen_complementaires,id"
        ]);

        $consultation = ConsultationPrenatale::find($request->get('consultation'));
        $consultation->examensComplementaire()->detach($request->get('examensComplementaire'));

        $consultation = ConsultationPrenatale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterExamenComplementaire(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_obstetriques,id",
            "examensComplementaire.*"=>"sometimes|integer|exists:examen_complementaires,id",
            "examensComplementaireACreer.*"=>"sometimes|string|min:2"
        ]);

        $examensComplementaire = $request->get('examensComplementaire');
        $examensComplementaireACreer = $request->get('examensComplementaireACreer');

        $consultation = ConsultationPrenatale::find($request->get('consultation'));

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

        defineAsAuthor("ConsultPrenExamCom",$consultation->id,'attach');

        $consultation = ConsultationPrenatale::with(['examensClinique','examensComplementaire'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
