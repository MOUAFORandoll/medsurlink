<?php

namespace App\Http\Controllers\Api;
use App\Models\Avis;
use App\Models\Patient;
use App\Models\Antecedent;
use App\Models\RendezVous;
use App\Models\Cardiologie;
use App\Models\LigneDeTemps;
use App\Models\DossierMedical;
use App\Models\ActivitesControle;
use App\Models\ActiviteAmaPatient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompteRenduOperatoire;
use App\Models\ConsultationObstetrique;
use App\Http\Requests\LigneDeTempsRequest;
use App\Models\Affiliation;
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
        $ligneTemps = LigneDeTemps::with(['dossier','motif'])->latest()->get();
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

        $ligneDeTemps = LigneDeTemps::with([
            'motif',
            'dossier',
        ])->whereId($id)->first();

        $dossier = DossierMedical::whereSlug($id)->first();
        // $examen_validation_assureur = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author'])
        //    ->whereNotNull('etat_validation_medecin')
        //    ->where('medecin_control_id', '=',Auth::id())->where('ligne_de_temps_id', '=', $ligneDeTemps)
        //    ->distinct()/*->groupBy('ligne_de_temps_id')*/
        //    ->latest()->get();
        // $examen_validation_medecin = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author','consultation.versionValidation'])
        //    ->whereNotNull('etat_validation_souscripteur')
        //    ->where('medecin_control_id', '=',Auth::id())->where('ligne_de_temps_id', '=', $ligneDeTemps)
        //    ->distinct()/*->groupBy('ligne_de_temps_id')*/
        //    ->latest()->get();

        $ligneDeTemps = LigneDeTemps::with([
            'motif',
            'dossier',
            'validations.examenComplementaire.examenComplementairePrix',
            'validations.consultation.versionValidation',
            'validations',
            // 'validations.consultation.ligneDeTemps.motif',
        ])->where("dossier_medical_id",$dossier->id)->latest()->get();

        return response()->json(["ligne_temps" => $ligneDeTemps]);
        // "examen_validation_medecin" => $examen_validation_medecin, "examen_validation_assureur" => $examen_validation_assureur
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
           ->distinct()/*->groupBy('ligne_de_temps_id')*/
           ->latest()->get();
        $examen_validation_medecin = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif','consultation.dossier.patient.user','consultation.author','consultation.versionValidation'])
           ->whereNotNull('etat_validation_souscripteur')
           ->where('medecin_control_id', '=',Auth::id())
           ->distinct()/*->groupBy('ligne_de_temps_id')*/
           ->latest()->get();
        $activites = ActiviteAmaPatient::with(['activitesAma','patient','patient.rendezVous','patient.medecinReferent.medecinControles','updatedBy','createur'])->where('patient_id',$patient->user_id)->get();
        $activites_referent = ActivitesControle::with(['activitesMedecinReferent','patient','updatedBy','createur'])->where('patient_id',$patient->user_id)->get();
        //Patient::with(['activitesAma','medecinReferent.createur','medecinReferent.medecinControles','rendezVous',])->where('user_id',$patient->user->id)->first();
        $rendezVous = RendezVous::where('patient_id',$patient->user_id)->latest()->get();
        $array = array('rendez_vous' =>$rendezVous,'activite_ama' =>  $activites,'activites_referent' =>  $activites_referent,'examen_validation_assureur' =>  $examen_validation_assureur, 'examen_validation_medecin' =>  $examen_validation_medecin);
        $referentArray = array('referent'=> $activites_referent);


        $contrat = getContrat($patient->user);
        $affiliations = Affiliation::with(['patient', 'souscripteur'])->where('patient_id',$patient->user_id)->latest()->get();
        $newAffiliations = collect($contrat->contrat);
        foreach($affiliations as $affiliation){
            $newAffiliation = new \stdClass();
            $newAffiliation->adresse_affilie = "";
            $newAffiliation->ageAffilie = 18;
            $newAffiliation->bornAroundAffilie = null;
            $newAffiliation->bornAroundSouscripteur = null;
            $newAffiliation->canal = "Website";
            $newAffiliation->code_promo = null;
            $newAffiliation->contrat_code = "96e181";
            $newAffiliation->created_at = "2022-05-12 07:56:06";
            $newAffiliation->dateNaissanceAffilie = "2004-02-11";
            $newAffiliation->dateNaissanceSouscripteur = "1998-01-15";
            $newAffiliation->dateSignature = "2022-05-12";
            $newAffiliation->date_paiement = null;
            $newAffiliation->decede = "non";
            $newAffiliation->deleted_at = null;
            $newAffiliation->emailSouscripteur1 = "fjfn@jdf.com";
            $newAffiliation->emailSouscripteur2 = null;
            $newAffiliation->etat = "GÉNÉRÉ";
            $newAffiliation->expire = 0;
            $newAffiliation->expire_mail_send = 0;
            $newAffiliation->id = 1512;
            $newAffiliation->lieuEtablissement = "Douala";
            $newAffiliation->montantSouscription = "65.000";
            $newAffiliation->nomAffilie = "KITIO";
            $newAffiliation->nomContact = "fdjjfd";
            $newAffiliation->nomPatient = "";
            $newAffiliation->nomSouscripteur = "sofa";
            $newAffiliation->nom_mere = "sdoiklkfs";
            $newAffiliation->nom_pere = "sdfkjlkds";
            $newAffiliation->nombre_envoi = 0;
            $newAffiliation->paye_par_affilie = "non";
            $newAffiliation->paysResidenceAffilie = "Cameroon";
            $newAffiliation->paysResidenceSouscripteur = "Cameroon";
            $newAffiliation->paysSouscription = "Cameroon";
            $newAffiliation->personneContact1 = "650198745";
            $newAffiliation->personneContact2 = null;
            $newAffiliation->plaintes = "ksdkllkds dskl";
            $newAffiliation->prenomAffilie = "AUDREY";
            $newAffiliation->prenomContact = "dsjkkf";
            $newAffiliation->prenomPatient = "";
            $newAffiliation->prenomSouscripteur = "teugoum";
            $newAffiliation->reduction = "non";
            $newAffiliation->reference_paiement = null;
            $newAffiliation->renouvelle =  "non";
            $newAffiliation->sexeAffilie =  "Mme";
            $newAffiliation->sexePatient =  "M";
            $newAffiliation->sexeSouscripteur =  "M";
            $newAffiliation->slug =  "xulqfofeeyamai6kewmb-1652342166";
            $newAffiliation->statut_paiement =  "NON PAYÉ";
            $newAffiliation->telephoneAffilie1 =  "00237650256320";
            $newAffiliation->telephoneAffilie2 =  null;
            $newAffiliation->telephoneSouscripeur1 =  "652012365";
            $newAffiliation->telephoneSouscripeur2 =  null;
            $newAffiliation->typeSouscription =  "Annuelle";
            $newAffiliation->type_paiement =  null;
            $newAffiliation->updated_at = "2022-05-12 07:56:06";
            $newAffiliation->urgence = "3";
            $newAffiliation->villeResidenceAffilie = "Lyon";
            $newAffiliation->villeResidenceSouscripteur = "fkokfdklfd lkfdkl";
            $newAffiliation->visiteur = "NON";

            $newAffiliations->push($newAffiliation);

        }





       //dd($patient->dossier->id);
       return response()->json(["cim" => $contrat,"dossier"=>$dossier,"patient"=>$patient,'activites'=> $array, 'affiliations' => $affiliations, 'referent' => $referentArray]);
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
