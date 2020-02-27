<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Allergie;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DossierMedical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DossierAllergieController extends Controller
{
    use PersonnalErrors;
    public function retirerAllergie(Request $request){
        $validation = Validator::make($request->all(),[
            "dossier"=>"required|integer|exists:dossier_medicals,id",
            "allergies.*"=>"required|integer|exists:allergies,id"
        ]);
        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $dossier = DossierMedical::find($request->get('dossier'));

        $this->checkIfAuthorized("DossierAllergie",$dossier->id,"attach");

        $dossier->allergies()->detach($request->get('allergies'));

        $dossier = DossierMedical::with([
            'patient',
            'consultationsObstetrique',
            'consultationsMedecine',
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            }
        ])->find($request->get('dossier'));
        $dossier->updateDossier();
        return response()->json(['dossier'=>$dossier]);
    }

    public function ajouterAllergie(Request $request){
        $validation = Validator::make($request->all(),[
            "dossier"=>"required|integer|exists:dossier_medicals,id",
//            "allergies"=>"required_without:allergiesACreer",
//            "allergiesACreer"=>"required_without:allergies",
//            "allergies.*"=>"sometimes|integer|exists:allergies,id",
            "allergiesACreer"=>"required|string|min:7",

        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

//        $allergies = $request->get('allergies');
        $allergiesACreer = $request->get('allergiesACreer');

        $dossier = DossierMedical::find($request->get('dossier'));

//        if (!is_null($allergiesACreer) or !empty($allergiesACreer)){
//            foreach ( $allergiesACreer as $allergy)
//            {
        $allergieCreer = Allergie::create([
            'description'=>$allergiesACreer,
//                    'date'=>array_key_exists('date',$allergy) ? $allergy['date'] : null
        ]);
        defineAsAuthor("Allergie",$allergieCreer->id,'create',$dossier->patient->user_id);
        $dossier->allergies()->attach($allergieCreer->id);
//            }
//        }

//        if (!is_null($allergies) or !empty($allergies)){
//                $dossier->allergies()->attach($allergies);
//        }

        defineAsAuthor("DossierAllergie",$dossier->id,'attach');
        $dossier = DossierMedical::with([
            'patient',
            'consultationsObstetrique',
            'consultationsMedecine',
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            }
        ])->find($request->get('dossier'));
        $dossier->updateDossier();
        return response()->json(['dossier'=>$dossier]);
    }

    public function ajouterAllergieVersionDeux(Request $request){
        $validation = Validator::make($request->all(),[
            "dossier_medical_id"=>"required|integer|exists:dossier_medicals,id",
            "description"=>"required",
            "date"=>"sometimes|nullable|date|before_or_equal:".Carbon::now()->format('Y-m-d'),
        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

        $descriptions = $request->get('description');
        $date = $request->get('date');

        $dossier = DossierMedical::find($request->get('dossier_medical_id'));
        foreach ($descriptions as $description){
            $converti = (integer) $description;
            if ($converti == 0){
                $allergieCreer = Allergie::create([
                    'description'=>$description,
                    'date'=>$date
                ]);
                defineAsAuthor("Allergie",$allergieCreer->id,'create',$dossier->patient->user_id);
                $dossier->allergies()->attach($allergieCreer->id);
            }
            else{
                $allergie = Allergie::find($description);
                $allergy = Allergie::create([
                    'description'=>$allergie->description,
                    'date'=>$date
                ]);
                defineAsAuthor("Allergie",$allergy->id,'create',$dossier->patient->user_id);
                $dossier->allergies()->attach($allergy->id);
            }

            defineAsAuthor("DossierAllergie",$dossier->id,'attach');

        }

        $dossier = DossierMedical::with([
            'patient',
            'consultationsObstetrique',
            'consultationsMedecine',
            'allergies'=> function ($query) {
                $query->orderBy('date', 'desc');
            }
        ])->find($request->get('dossier_medical_id'));
        return response()->json(['dossier'=>$dossier]);
    }
}
