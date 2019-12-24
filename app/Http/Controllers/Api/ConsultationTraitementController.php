<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\ConsultationMedecineGenerale;
use App\Models\Traitement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultationTraitementController extends Controller
{
    use PersonnalErrors;
    public function retirerTraitement(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "traitements.*"=>"required|integer|exists:traitements,id"
        ]);
        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        $this->checkIfAuthorized("ConsultationTraitement",$consultation->id,"attach");

        $consultation->traitements()->detach($request->get('traitements'));

        $consultation = ConsultationMedecineGenerale::with(['examensClinique','traitements','examensComplementaire','traitements'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterTraitement(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "traitements.*.id"=>"required|integer|exists:traitements,id",
            "traitements.*.date"=>"required|date",
            "traitementsACreer.*.intitule"=>"sometimes|string|min:2",
            "traitementsACreer.*.date"=>"sometimes|date|min:2"
        ]);
        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }
        $traitements = $request->get('traitements');
        $traitementsACreer = $request->get('traitementsACreer');

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        if (!is_null($traitementsACreer) or !empty($traitementsACreer)){
            foreach ( $traitementsACreer as $traitement)
            {
                $traitementCreer = Traitement::create([
                    'intitule'=>$traitement['intitule']
                ]);
                $consultation->traitements()->attach($traitementCreer->id,['date'=>$traitementCreer['date']]);
            }
        }

        if (!is_null($traitements) or !empty($traitements)){
            foreach ($traitements as $allergy) {
                $consultation->traitements()->attach($allergy['id'],['date'=>$allergy['date']]);
            }
        }


        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','traitements','conclusions','parametresCommun'])->whereSlug($consultation->slug)->first();

        defineAsAuthor("ConsultationTraitement",$consultation->id,'attach', $consultation->dossier->patient->user_id);

        $consultation->updateConsultationMedecine();

        return response()->json(['consultation'=>$consultation]);
    }
}
