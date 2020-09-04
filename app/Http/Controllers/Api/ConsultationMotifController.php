<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\Motif;
use App\Traits\DossierTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultationMotifController extends Controller
{
    use DossierTrait;
    public function removeMotif(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "motifs.*"=>"required|integer|exists:motifs,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));

        $motifs = $request->get('motifs');
        foreach ($motifs as $motif){
            $consultation->motifs()->detach($motif);
            defineAsAuthor("ConsultationMotif", $motif, 'detach',$consultation->dossier->patient->user_id);
        }

        $consultation = ConsultationMedecineGenerale::with(['dossier', 'traitements', 'conclusions', 'parametresCommun'])->find($consultation->id);

        if (!is_null($consultation))
            $consultation->updateConsultationMedecine();

        $this->updateDossierId($consultation->dossier->id);

        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterMotif(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "consultation" => "required|string|exists:consultation_medecine_generales,slug",
            "reference" => ["required", "string", "max:255"],
            "description" => ["required", "string"]
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 419);
        }

        $consultation = ConsultationMedecineGenerale::findBySlug($request->get('consultation'));

        $motif = Motif::create([
            'reference' => $request->get('reference'),
            'description' => $request->get('description')
        ]);
        defineAsAuthor("Motif", $motif->id, 'create');
        $consultation->motifs()->attach($motif->id);

        defineAsAuthor("ConsultationMotif", $motif->id, 'attach',$consultation->dossier->patient->user_id);

        $consultation = ConsultationMedecineGenerale::with(['dossier', 'traitements', 'conclusions', 'parametresCommun'])->find($consultation->id);

        if (!is_null($consultation))
            $consultation->updateConsultationMedecine();

        $this->updateDossierId($consultation->dossier->id);

        return response()->json(['consultation'=>$consultation]);
    }
}
