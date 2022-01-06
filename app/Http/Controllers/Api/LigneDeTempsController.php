<?php

namespace App\Http\Controllers\Api;
use App\Models\Avis;
use App\Models\Patient;
use App\Models\Antecedent;
use App\Models\RendezVous;
use App\Models\Cardiologie;
use App\Models\LigneDeTemps;
use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\ActiviteMission;
use App\Models\ActivitesControle;
use App\Models\ActiviteAmaPatient;
use App\Models\ConsultationFichier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompteRenduOperatoire;
use App\Models\ConsultationObstetrique;
use App\Http\Requests\LigneDeTempsRequest;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationMedecineGenerale;

class LigneDeTempsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ligneTemps = LigneDeTemps::with(['dossier','motif'])->get();
        return response()->json(['ligne_temps'=>$ligneTemps]);
    }

    public function ligneDeTemps($id)
    {
        $dossier = DossierMedical::whereSlug($id)->first();
        $ligneTemps = LigneDeTemps::with(['dossier','motif'])->get();
        return response()->json(['ligne_temps'=>$ligneTemps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LigneDeTempsRequest $request)
    {
        // création d'une ligne de temps
        $ligneDeTemps = LigneDeTemps::create($request->validated(),['motif_consultation_id','dossier_medical_id','date_consultation']);

        // Sauvegarde des contributeurs
        $contributeurs = $request->get('contributeurs');
        addContributors($contributeurs,$ligneDeTemps,'LigneDeTemps');

        return response()->json(["ligne_temps" => $ligneDeTemps]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $ligneDeTemps = LigneDeTemps::with([
            'motif',
            'dossier',
        ])->whereId($id)->first();

        return response()->json(["ligne_temps" => $ligneDeTemps]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ligneDeTempsByDossier($id)
    {

        $dossier = DossierMedical::whereSlug($id)->first();

        $ligneDeTemps = LigneDeTemps::with([
            'motif',
            'dossier',
            'prescriptionValidation',
            'consultationObstetrique',
            'cardiologie',
            'consultationGeneral',
            'kenesitherapie',
            'validations'
        ])->where("dossier_medical_id",$dossier->id)->get();

        return response()->json(["ligne_temps" => $ligneDeTemps]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * get patient contrat from medicasure.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function patientContrat($id)
    {
       $patient = Patient::where("user_id",$id)->first();
       $contrat = getContrat($patient->user);
       return response()->json($contrat);
    }

    /**
     * get trajet patient .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function getTrajetPatient($id)
    {
        //Auth::loginUsingId(1);
        $dossier = DossierMedical::whereSlug($id)
         ->with(
            // "resultatsImagerie",
            // "resultatsLabo",
            // "hospitalisations",
            // "consultationsObstetrique",
            "consultationsMedecine",
            "consultationsMedecine.validations.examenComplementaire.examenComplementairePrix",
            // "traitements",
            // "ordonances",
            // "cardiologies",
            // "comptesRenduOperatoire",
            // "kinesitherapies",
            "avis",
            // "consultationsManuscrites"
            )->first();

       $patient = Patient::where('user_id', DossierMedical::whereSlug($id)->first()->patient_id)
       ->with([
           "medecinReferent",
           "payments",
           "dossier",
           "rendezVous"])->first();
        $examen_validation_assureur = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
           ->whereNotNull('etat_validation_medecin')
           ->where('medecin_control_id', '=',Auth::id())
           ->distinct()
           ->get();
        $examen_validation_medecin = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
           ->whereNotNull('etat_validation_souscripteur')
           ->where('medecin_control_id', '=',Auth::id())
           ->distinct()
           ->get();
        $activites = ActiviteAmaPatient::with(['activitesAma','patient','patient.rendezVous','patient.medecinReferent.medecinControles','updatedBy','createur'])->where('patient_id',$patient->user_id)->get();
        $activitesmed = ActivitesControle::with(['createur','ActivitesMedecinReferent']);
        //Patient::with(['activitesAma','medecinReferent.createur','medecinReferent.medecinControles','rendezVous',])->where('user_id',$patient->user->id)->first();
        $rendezVous = RendezVous::where('patient_id',$patient->user_id)->get();
        $array = array('activitesmedReferent' =>$activitesmed,'rendez_vous' =>$rendezVous,'activite_ama' =>  $activites,'examen_validation_assureur' =>  $examen_validation_assureur, 'examen_validation_medecin' =>  $examen_validation_medecin);
        

        $contrat = getContrat($patient->user);

       //dd($patient->dossier->id);
       return response()->json(["cim" => $contrat,"dossier"=>$dossier,"patient"=>$patient,'activites'=> $array]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LigneDeTempsRequest $request, $id)
    {
        $ligneDeTemps = LigneDeTemps::whereId($id)->first();

        if ($ligneDeTemps != null){
            // Modification de la consultation

            $ligneDeTemps->whereId($id)->update($request->validated());
            defineAsAuthor("LigneDeTemps",$ligneDeTemps->id,'update',$ligneDeTemps->dossier->patient->user_id);

            return response()->json(["ligne_temps" => $ligneDeTemps]);
        }
        return response()->json(["ligne_temps" => $ligneDeTemps]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ligneDeTemps = LigneDeTemps::whereId($id)->first();

        if (!is_null($ligneDeTemps)){
            $this->updateDossierId($ligneDeTemps->dossier->id);
            $ligneDeTemps->delete();
        }
        return  response()->json(['ligne_temps'=>$ligneDeTemps]);
    }
}
