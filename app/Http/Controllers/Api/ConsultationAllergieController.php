<?php

namespace App\Http\Controllers\Api;

use App\Models\Allergie;
use App\Models\ConsultationMedecineGenerale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationAllergieController extends Controller
{
    public function retirerAllergie(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "allergies.*"=>"required|integer|exists:allergies,id"
        ]);



        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("ConsultationAllergie",$consultation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }

        $consultation->allergies()->detach($request->get('allergies'));

        $consultation = ConsultationMedecineGenerale::with(['examensClinique','allergies','examensComplementaire'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterAllergie(Request $request){
        $request->validate([
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "allergies.*.id"=>"required|integer|exists:allergies,id",
            "allergies.*.date"=>"required|date",
            "allergiesACreer.*.intitule"=>"sometimes|string|min:2",
            "allergiesACreer.*.date"=>"sometimes|date|min:2"
        ]);

        $allergies = $request->get('allergies');
        $allergiesACreer = $request->get('allergiesACreer');

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        if (!is_null($allergiesACreer) or !empty($allergiesACreer)){
            foreach ( $allergiesACreer as $allergy)
            {
                $allergieCreer = Allergie::create([
                    'intitule'=>$allergy['intitule']
                ]);
                $consultation->allergies()->attach($allergieCreer->id,['date'=>$allergy['date']]);
            }
        }

        if (!is_null($allergies) or !empty($allergies)){
            foreach ($allergies as $allergy) {
                $consultation->allergies()->attach($allergy['id'],['date'=>$allergy['date']]);
            }
        }

        defineAsAuthor("ConsultationAllergie",$consultation->id,'attach');
        $consultation = ConsultationMedecineGenerale::with('examensClinique','examensComplementaire','allergies')->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }
}
