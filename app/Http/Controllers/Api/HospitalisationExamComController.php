<?php

namespace App\Http\Controllers\Api;

use App\Models\ExamenComplementaire;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HospitalisationExamComController extends Controller
{
    public function retirerExamenComplementaire(Request $request){
        $request->validate([
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensComplementaire.*"=>"required|integer|exists:examen_complementaires,id"
        ]);

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));
        $hospitalisation->examensComplementaire()->detach($request->get('examensComplementaire'));

        $hospitalisation = Hospitalisation::with(['examensClinique','examensComplementaire'])->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    public function ajouterExamenComplementaire(Request $request){

        $request->validate([
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensComplementaire.*"=>"sometimes|integer|exists:examen_complementaires,id",
            "examensComplementaireACreer.*"=>"sometimes|string|min:2"
        ]);
        $examensComplementaire = $request->get('examensComplementaire');
        $examensComplementaireACreer = $request->get('examensComplementaireACreer');

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));

        if (!is_null($examensComplementaireACreer) or !empty($examensComplementaireACreer)){
            foreach ( $examensComplementaireACreer as $examen)
            {
                $examen = ExamenComplementaire::create([
                    'reference'=>$examen
                ]);
                $hospitalisation->examensComplementaire()->attach($examen->id);
            }
        }

        if (!is_null($examensComplementaire) or !empty($examensComplementaire)){
            $hospitalisation->examensComplementaire()->attach($examensComplementaire);
        }


        $hospitalisation = Hospitalisation::with(['examensClinique','examensComplementaire'])->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }
}
