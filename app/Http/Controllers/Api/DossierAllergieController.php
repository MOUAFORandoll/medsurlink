<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Traits\PersonnalErrors;
use App\Models\Allergie;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DossierMedical;
use App\Traits\DossierTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActiviteAmaPatient;
use App\Models\ActivitesControle;
use App\Models\Affiliation;
use App\Models\LigneDeTemps;
use App\User;
use Illuminate\Support\Facades\Validator;

class DossierAllergieController extends Controller
{
    use PersonnalErrors;
    use DossierTrait;
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
        $this->updateDossierId($dossier->id);

        return response()->json(['dossier'=>$dossier]);
    }

    public function ajouterAllergie(Request $request){
        $validation = Validator::make($request->all(),[
            "dossier"=>"required|integer|exists:dossier_medicals,id",
//            "allergies"=>"required_without:allergiesACreer",
//            "allergiesACreer"=>"required_without:allergies",
//            "allergies.*"=>"sometimes|integer|exists:allergies,id",
            "allergiesACreer"=>"required|string|min:3",

        ]);

        if ($validation->fails()){
            return response()->json(['error'=>$validation->errors()],419);
        }

//        $allergies = $request->get('allergies');
        $allergiesACreer = $request->get('allergiesACreer');

        $dossier = DossierMedical::find($request->get('dossier'));

        $affiliation = Affiliation::where("patient_id", $dossier->patient_id)->latest()->first();
        $ligne_temps = LigneDeTemps::where('dossier_medical_id', $dossier->id)->latest()->first();
        $user = User::find($dossier->patient_id);
        foreach($request->activity_id as $activity_id){
            if(auth()->user()->hasrole("Medecin controle")){
                $activite = ActivitesControle::create([
                    "activite_id" => $activity_id['id'],
                    "patient_id" => $dossier->patient_id,
                    'etablissement_id' => $request->etablissement_id,
                    'affiliation_id' => $affiliation ? $affiliation->id : null,
                    'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
                    "creator" => auth()->user()->id,
                    "commentaire" => "Ajout d'une allergie pour le patient {$user->name}",
                    "statut" => $request->statut,
                    "date_cloture" => $request->date_cloture
                ]);

            }else{
                $activite = ActiviteAmaPatient::create([
                    'activite_ama_id' => $activity_id['id'],
                    'date_cloture' => date('Y-m-d'),
                    'affiliation_id' => $affiliation ? $affiliation->id : null,
                    'commentaire' => "Ajout d'une allergie pour le patient {$user->name}",
                    'ligne_temps_id' => $ligne_temps ? $ligne_temps->id : null,
                    'patient_id' => $dossier->patient_id,
                    'etablissement_id' => $request->etablissement_id,
                    'statut' => $request->statut,
                ]);
            }
        }



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
        $this->updateDossierId($dossier->id);

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
        $this->updateDossierId($dossier->id);

        return response()->json(['dossier'=>$dossier]);
    }
}
