<?php

namespace App\Http\Controllers\Api;

use App\Models\Hospitalisation;
use App\Models\Motif;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HospitalisationMotifController extends Controller
{
    public function removeMotif(Request $request){
        $validation = Validator::make($request->all(),[
            "hospitalisation_id"=>"required|integer|exists:hospitalisations,id",
            "motifs.*"=>"required|integer|exists:motifs,id"
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation_id'));
        $hospitalisation->motifs()->detach($request->get('motifs'));

        $hospitalisation = Hospitalisation::with('motifs')->find($request->get('hospitalisation_id'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    public function ajouterMotif(Request $request){
        $validation = Validator::make($request->all(),[
            "hospitalisation_id"=>"required|integer|exists:hospitalisations,id",
            "motifs"=>"required_without:motifsACreer",
            "motifsACreer"=>"required_without:motifs",
            "motifs.*"=>"required_without:motifsACreer|integer|exists:motifs,id",
            "motifsACreer.*.reference"=>"required_without:motifs|string|min:2",
            "motifsACreer.*.description"=>"required_without:motifs|string|min:2",
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation_id'));
        if (!is_null($request->get('motifs'))){
            $hospitalisation->motifs()->attach($request->get('motifs'));

        }

        $motifs = $request->get('motifsACreer');
        if (!is_null($motifs) or !empty($motifs)){
            foreach ( $motifs as $motif)
            {
                $motifCreer = Motif::create([
                    'reference'=>$motif['reference'],
                    'description'=>$motif['description']
                ]);

                $hospitalisation->motifs()->attach($motifCreer->id);
            }
        }
        $hospitalisation = Hospitalisation::with('motifs')->find($request->get('hospitalisation_id'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }
}
