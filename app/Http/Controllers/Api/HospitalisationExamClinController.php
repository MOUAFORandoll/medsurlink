<?php

namespace App\Http\Controllers\Api;

use App\Models\ExamenClinique;
use App\Models\Hospitalisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HospitalisationExamClinController extends Controller
{
    public function retirerExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensClinique.*"=>"required|integer|exists:examen_cliniques,id"
        ]);

        if ($validation->fails())
            return response()->json(['error'=>$validation->errors()],419);

        $hospitalisation = Hospitalisation::find($request->get('hospitalisation'));

        $isAuthor = checkIfIsAuthorOrIsAuthorized("HospitalisationExamClin",$hospitalisation->id,"attach");
        if($isAuthor->getOriginalContent() == false){
            return response()->json(['error'=>"Vous ne pouvez modifié un élement que vous n'avez crée"],401);
        }


        $hospitalisation->examensClinique()->detach($request->get('examensClinique'));

        $hospitalisation = Hospitalisation::with('examensClinique')->find($request->get('hospitalisation'));
        return response()->json(['hospitalisation'=>$hospitalisation]);
    }

    public function ajouterExamenClinique(Request $request){
        $validation = Validator::make($request->all(),[
            "hospitalisation"=>"required|integer|exists:hospitalisations,id",
            "examensClinique.*"=>"sometimes|integer|exists:examen_cliniques,id",
            "examensCliniqueACreer.*"=>"sometimes|string|min:2"
        ]);

        if ($validation->fails())
            return response()->json(['error'=>$validation->errors()],419);

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
