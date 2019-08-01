<?php

namespace App\Http\Controllers\Api;

use App\Models\ExamenClinique;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HospitalisationExamClinController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $request->validate([
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));
        $hospitalisation->examensClinique()->detach($request->get('examensClinique'));

        $hospitalisation = Hospitalisation::with('examensClinique')->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    public function ajouterExamenClinique(Request $request){
        $request->validate([
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

        $examensClinique = $request->get('examensClinique');
        $examensCliniqueACreer = $request->get('examensCliniqueACreer');

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));

        if (!is_null($examensCliniqueACreer) or !empty($examensCliniqueACreer)){
            foreach ( $examensCliniqueACreer as $examen)
            {
                $examen = ExamenClinique::create([
                    'reference'=>$examen
                ]);
                $hospitalisation->examensClinique()->attach($examen->id);
            }
        }

        if (!is_null($examensClinique) or !empty($examensClinique)){
            $hospitalisation->examensClinique()->attach($examensClinique);
        }

        defineAsAuthor("HospitalisationExamClin",$hospitalisation->id,'attach');

        $hospitalisation = Hospitalisation::with('examensClinique')->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }
}
