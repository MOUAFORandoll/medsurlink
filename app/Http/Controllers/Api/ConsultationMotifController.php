<?php

namespace App\Http\Controllers\Api;

use App\Models\ConsultationMedecineGenerale;
use App\Models\Motif;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConsultationMotifController extends Controller
{
    public function removeMotif(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|integer|exists:consultation_medecine_generales,id",
            "motifs.*"=>"required|integer|exists:motifs,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::find($request->get('consultation'));
        $consultation->motifs()->detach($request->get('motifs'));

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','examensClinique','examensComplementaire','traitements','conclusions'])->find($request->get('consultation'));
        return response()->json(['consultation'=>$consultation]);
    }

    public function ajouterMotif(Request $request){
        $validation = Validator::make($request->all(),[
            "consultation"=>"required|string|exists:consultation_medecine_generales,slug",
            "reference" => ["required", "string", "max:255"],
            "description" => ["required", "string"]
            /*"motifs"=>"required_without:motifsACreer",
            "motifsACreer"=>"required_without:motifs",
            "motifs.*"=>"required_without:motifsACreer|integer|exists:motifs,id",
            "motifsACreer.*.reference"=>"required_without:motifs|string|min:2",
            "motifsACreer.*.description"=>"required_without:motifs|string|min:2",*/
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $consultation = ConsultationMedecineGenerale::findBySlug($request->get('consultation'));
        /*if (!is_null($request->get('motifs'))){
            $consultation->motifs()->attach($request->get('motifs'));

        }

        $motifs = $request->get('motifsACreer');
        if (!is_null($motifs) or !empty($motifs)){
            foreach ( $motifs as $motif)
            {
                $motifCreer = Motif::create([
                    'reference'=>$motif['reference'],
                    'description'=>$motif['description']
                ]);

                $consultation->motifs()->attach($motifCreer->id);
            }
        }*/

        $motif = Motif::create([
            'reference' => $request->get('reference'),
            'description' => $request->get('description')
        ]);

        $consultation->motifs()->attach($motif->id);

        $consultation = ConsultationMedecineGenerale::with(['dossier','motifs','examensClinique','examensComplementaire','traitements','conclusions'])
            ->find($request->get('consultation'));

        return response()->json(['consultation'=>$consultation]);
    }
}
