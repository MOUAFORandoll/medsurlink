<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\Traitement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationTraitementController extends Controller
{
    public function retirerTraitement(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "traitements.*"=>"required|integer|exists:traitements,id"
        ]);

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));
        $consultation->traitements()->detach($request->get('traitements'));

        $consultation = ConsultationMedecineGenerale::with(['examensClinique','traitements','examensComplementaire','traitements'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterTraitement(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "traitements.*.id"=>"required|integer|exists:traitements,id",
            "traitements.*.date"=>"required|date",
            "traitementsACreer.*.intitule"=>"sometimes|string|min:2",
            "traitementsACreer.*.date"=>"sometimes|date|min:2"
        ]);

        $traitements = $request->get('traitements');
        $traitementsACreer = $request->get('traitementsACreer');

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        if (!is_null($traitementsACreer) or !empty($traitementsACreer)){
            foreach ( $traitementsACreer as $allergy)
            {
                $allergieCreer = Traitement::create([
                    'intitule'=>$allergy['intitule']
                ]);
                $consultation->traitements()->attach($allergieCreer->id,['date'=>$allergy['date']]);
            }
        }

        if (!is_null($traitements) or !empty($traitements)){
            foreach ($traitements as $allergy) {
                $consultation->traitements()->attach($allergy['id'],['date'=>$allergy['date']]);
            }
        }


        $consultation = ConsultationMedecineGenerale::with(['examensClinique','examensComplementaire','traitements','traitements'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
