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
            "hospitalisation" => ["required", "string", "exists:hospitalisations,slug"],
            "reference" => ["required", "string", "max:255"],
            "description" => ["required", "string"]
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $hospitalisation = Hospitalisation::findBySlug($request->get('hospitalisation'));

        $motif = Motif::create([
            'reference' => $request->get('reference'),
            'description' => $request->get('description')
        ]);

        $hospitalisation->motifs()->attach($motif->id);
        defineAsAuthor("HospitalisationMotif",$hospitalisation->id,'attach',$hospitalisation->dossier->patient->user_id);

        $hospitalisation = Hospitalisation::with('motifs')
            ->find($request->get('hospitalisation'));

        return response()->json(['hospitalisation' => $hospitalisation]);
    }
}
