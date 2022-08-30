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
use App\Models\ConsultationFichier;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DelaiOperation;
use App\Models\MedecinAvis;
use App\Models\Motif;
use App\Models\PatientMedecinControle;
use App\Models\ResultatImagerie;
use App\Models\ResultatLabo;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

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
        $ligneTemps = LigneDeTemps::whereHas('dossier', function ($query) use($id) {
            $query->where('slug', $id);
        })->with(['motif', 'dossier'])->get();
        return response()->json(['ligne_temps' => $ligneTemps]);
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
        $all_plaintes = explode(",", $request->plaintes);
        $plaintes = [];
        foreach($all_plaintes as $plainte){
            if(str_contains($plainte, 'item_')){
                /**
                 * on créé une nouvelle plainte si elle n'existe pas
                 */
                $motif = Motif::where(["description" => explode("item_", $plainte)[1]])->first();
                if(is_null($motif)){
                    $motif = Motif::create(["reference" => now(), "description" => explode("item_", $plainte)[1]]);
                    defineAsAuthor("Motif",$motif->id,'create');
                }
                $plaintes[] = $motif->id;
            }else{
                $plaintes[] = $plainte;
            }
        }
        // création d'une ligne de temps
        $ligne_temps = LigneDeTemps::create(['dossier_medical_id' => $request->dossier_medical_id, 'motif_consultation_id' => $plaintes[0], 'etat' => 1, 'date_consultation' => $request->date_consultation, 'affiliation_id' => $request->affiliation_id]);
        $ligne_temps->motifs()->sync($plaintes);
        $ligne_temps->cloture()->create([]);

        // Sauvegarde des contributeurs
        $contributeurs = $request->get('contributeurs');
        addContributors($contributeurs, $ligne_temps, 'LigneDeTemps');

        return response()->json(["ligne_temps" => $ligne_temps]);
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

        // $ligneDeTemps = LigneDeTemps::with([
        //     'motif',
        //     'dossier',
        // ])->whereId($id)->first();

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
        ])->where("dossier_medical_id", $dossier->id)->latest()->get();

        $delai_opeartions = DelaiOperation::where('patient_id', $dossier->patient_id)->latest()->get();
        $ligne_temps = collect();
        $new_ligne_delais = collect(); //
        $ecart_en_second = 0;
        /**
         * récupérations des délais d'opérations
         */
        foreach($delai_opeartions as $delai){
            $model = $delai->delai_operationable_type::find($delai->delai_operationable_id);
            if($delai->delai_operationable_type == ResultatLabo::class || $delai->delai_operationable_type == ResultatImagerie::class){
                $consultation = $model->dossier->consultationsMedecine()->latest()->first();
                if(!is_null($consultation)){
                    $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                    $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                    $ligne = $consultation->ligneDeTemps;
                    $ligne->date_heure_prevue = $delai->date_heure_prevue;
                    $ligne->date_heure_effectif = $delai->date_heure_effectif;
                    $ligne->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    $new_ligne_delais->push($ligne);
                }
            }
            elseif($delai->delai_operationable_type == PatientMedecinControle::class){
                $consultation = $model->patients->dossier->consultationsMedecine()->latest()->first();
                if(!is_null($consultation)){
                    $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                    $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                    $ligne = $consultation->ligneDeTemps;
                    $ligne->date_heure_prevue = $delai->date_heure_prevue;
                    $ligne->date_heure_effectif = $delai->date_heure_effectif;
                    $ligne->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    $new_ligne_delais->push($ligne);
                }
            }
            elseif($delai->delai_operationable_type == ActiviteAmaPatient::class){
                $ligne = $model->ligne_temps;
                $ligne_temp = new \stdClass();
                $ligne_temp->id = $ligne->id;
                $ligne_temp->dossier_medical_id = $ligne->dossier_medical_id;
                $ligne_temp->etat = $ligne->etat;
                $ligne_temp->motif_consultation_id = $ligne->motif_consultation_id;
                $ligne_temp->date_consultation = $ligne->date_consultation;
                $ligne_temp->affiliation_id = $ligne->affiliation_id;
                $ligne_temp->created_at = $ligne->created_at;
                $ligne_temp->updated_at = $ligne->updated_at;
                $ligne_temp->deleted_at = $ligne->deleted_at;
                $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                $ligne_temp->date_heure_prevue = $delai->date_heure_prevue;
                $ligne_temp->date_heure_effectif = $delai->date_heure_effectif;
                $ligne_temp->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                $new_ligne_delais->push($ligne_temp);
            }
            elseif($delai->delai_operationable_type == ConsultationFichier::class){
                $consultation = $model->dossier->consultationsMedecine()->latest()->first();
                if(!is_null($consultation)){
                    $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                    $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                    $ligne = $consultation->ligneDeTemps;
                    $ligne->date_heure_prevue = $delai->date_heure_prevue;
                    $ligne->date_heure_effectif = $delai->date_heure_effectif;
                    $ligne->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    $new_ligne_delais->push($ligne);
                }
            }
            elseif($delai->delai_operationable_type == ConsultationMedecineGenerale::class){
                $consultation = $model;
                $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                $ligne = $consultation->ligneDeTemps;
                $ligne->date_heure_prevue = $delai->date_heure_prevue;
                $ligne->date_heure_effectif = $delai->date_heure_effectif;
                $ligne->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                $new_ligne_delais->push($ligne);
            }
            elseif($delai->delai_operationable_type == MedecinAvis::class){
                $consultation = $model->avisMedecin->dossier->consultationsMedecine()->latest()->first();
                if(!is_null($consultation)){
                    $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                    $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                    $ligne = $consultation->ligneDeTemps;
                    $ligne->date_heure_prevue = $delai->date_heure_prevue;
                    $ligne->date_heure_effectif = $delai->date_heure_effectif;
                    $ligne->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                    $new_ligne_delais->push($ligne);
                }
            }elseif($delai->delai_operationable_type == ActivitesControle::class){
                $ligne = $model->ligne_temps;
                $ligne_temp = new \stdClass();
                $ligne_temp->id = $ligne->id;
                $ligne_temp->dossier_medical_id = $ligne->dossier_medical_id;
                $ligne_temp->etat = $ligne->etat;
                $ligne_temp->motif_consultation_id = $ligne->motif_consultation_id;
                $ligne_temp->date_consultation = $ligne->date_consultation;
                $ligne_temp->affiliation_id = $ligne->affiliation_id;
                $ligne_temp->created_at = $ligne->created_at;
                $ligne_temp->updated_at = $ligne->updated_at;
                $ligne_temp->deleted_at = $ligne->deleted_at;
                $date_heure_prevue = Carbon::parse($delai->date_heure_prevue);
                $date_heure_effectif = Carbon::parse($delai->date_heure_effectif);
                $ligne_temp->date_heure_prevue = $delai->date_heure_prevue;
                $ligne_temp->date_heure_effectif = $delai->date_heure_effectif;
                $ligne_temp->ecart_en_second = $date_heure_effectif->DiffInSeconds($date_heure_prevue);
                $new_ligne_delais->push($ligne_temp);
            }

            
        }

        foreach($ligneDeTemps as $ligneTemps){
            if(is_null($ligneTemps->cloture)){
                $ligneTemps->cloture()->create([]);
            }
            $validations = collect();
            foreach($ligneTemps->validations as $validation){
                if($validation->consultation != null){
                    $validation->histories = DB::table('model_changes_history')->where(['model_id' => $validation->consultation->versionValidation->id, 'model_type' => 'App\Models\VersionValidation', 'change_type' => 'updated'])->orderBy('created_at', 'desc')->get(['changes']);
                    $validations->push($validation);
                }
            }
            Carbon::setLocale('fr');
            $ecart_en_second = $new_ligne_delais->Where('id', $ligneTemps->id)->sum('ecart_en_second');
            $ligneTemps->duree = CarbonInterval::seconds($ecart_en_second)->cascade()->forHumans(['short' => true, 'parts' => 3]);
            $ligneTemps->validations = $validations;
            $ligne_temps->push($ligneTemps);
        }
        
        // \Log::alert($ligne_temps);
        return response()->json(["ligne_temps" => $ligne_temps]);
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
         ->with([
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
            ])->first();
        $consultations = collect();
        foreach($dossier->consultationsMedecine as $consultation){
            $validations = collect();
            foreach($consultation->validations as $validation){
                $validation->histories = DB::table('model_changes_history')->where(['model_id' => $validation->consultation->versionValidation->id, 'model_type' => 'App\Models\VersionValidation', 'change_type' => 'updated'])->orderBy('created_at', 'desc')->get(['changes']);
                $validations->push($validation);
            }
            $consultation->validations = $validations;
            $consultations->push($consultation);
        }



        $dossier->consultationsMedecine = $consultations;

       $patient = Patient::where('user_id', DossierMedical::whereSlug($id)->first()->patient_id)
       ->with([
           "medecinReferent",
           "payments",
           "dossier",
           "rendezVous"])->first();
       /*  $examen_validation_assureur = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif:id,description','consultation.dossier.patient.user','consultation.author'])->whereHas('consultation.dossier', function($query) use($patient) {
            $query->where('patient_id', $patient->user_id);
        })->whereNotNull('etat_validation_medecin')->distinct()->latest()->get()->unique('consultation_general_id');

        $examen_validation_medecin = ConsultationExamenValidation::with(['consultation.ligneDeTemps.motif:id,description','consultation.dossier.patient.user','consultation.author','consultation.versionValidation'])->whereHas('consultation.dossier', function($query) use($patient) {
            $query->where('patient_id', $patient->user_id);
        })->whereNotNull('etat_validation_souscripteur')->distinct()->latest()->get()->unique('consultation_general_id'); */

        /**
         * ici nous retournons l'ensemble des activités ama qui nes sont pas relié à une line de temps
         */
        $activite_ama_isoles = ActiviteAmaPatient::doesntHave('affiliation')->with(['activitesAma:id,description_fr,created_at', 'updatedBy', 'createur:id,nom,prenom', 'ligne_temps:id,date_consultation,motif_consultation_id', 'ligne_temps.motif:id,description', 'etablissement:id,name'])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'activite_ama_id', 'creator', 'ligne_temps_id', 'etablissement_id', 'created_at']);
        $activites_referent_isoles = ActivitesControle::doesntHave('affiliation')->with(['activitesMedecinReferent:id,description_fr','updatedBy','createur:id,nom,prenom', 'ligne_temps:id,date_consultation,motif_consultation_id', 'ligne_temps.motif:id,description', 'etablissement:id,name'])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'activite_id', 'creator', 'ligne_temps_id', 'etablissement_id', 'created_at']);

        /**
         * ici nous retournons la liste des affiliations avec lignes de temps associées et pour chaque ligne de temps, ses activités AMA
         */
        $activite_ama_manuelles = Affiliation::with(['cloture', 'package:id,description_fr', 'ligneTemps.motif:id,description', 'ligneTemps.cloture', 'ligneTemps.activites_ama_patients.activitesAma:id,description_fr', 'ligneTemps.activites_ama_patients' => function ($query) use ($patient) {
            $query->where('patient_id', $patient->user_id);
        }])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);

        $activites_referent_manuelles = Affiliation::with(['cloture', 'package:id,description_fr', 'ligneTemps.motif:id,description', 'ligneTemps', 'ligneTemps.activites_referent_patients.activitesMedecinReferent:id,description_fr', 'ligneTemps.activites_referent_patients' => function ($query) use ($patient) {
            $query->where('patient_id', $patient->user_id);
        }])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);

        // $activites_referent_manuelles = ActivitesControle::with(['activitesMedecinReferent','patient','updatedBy','createur'])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get();
        //Patient::with(['activitesAma','medecinReferent.createur','medecinReferent.medecinControles','rendezVous',])->where('user_id',$patient->user->id)->first();

        $rdata = Affiliation::has('ligneTemps.rendezVous')->with(['package:id,description_fr'])->where('patient_id', $patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);
        $rendezVous_affiliations = collect();
        foreach($rdata as $affiliation){
            $ligne_temps = LigneDeTemps::with(['rendezVous.etablissement:id,name', 'rendezVous.praticien:id,nom,prenom', 'motif:id,description'])->where('affiliation_id', $affiliation->id)->orderBy('updated_at', 'desc')->get();
            $affiliation->ligne_temps = $ligne_temps;
            $rendezVous_affiliations->push($affiliation);
        }

        $rendezVous = RendezVous::doesntHave('ligne_temps.affiliation')->where('patient_id',$patient->user_id)->with(['ligne_temps:id,date_consultation,affiliation_id', 'praticien:id,nom,prenom', 'etablissement:id,name'])->latest()->get(['id', 'date', 'statut', 'motifs', 'ligne_temps_id', 'praticien_id', 'etablissement_id', 'created_at']);

        $array = array('rendez_vous' => $rendezVous, 'rendezVous_affiliations' => $rendezVous_affiliations, 'activite_ama_isoles' =>  $activite_ama_isoles, 'activites_referent_isoles' =>  $activites_referent_isoles, 'activite_ama_manuelles' => $activite_ama_manuelles);

        $referentArray = array('activites_referent_manuelles' => $activites_referent_manuelles);

        $contrat = getContrat($patient->user);

        $affiliations = Affiliation::with(['patient.user', 'souscripteur.user', 'package', 'cloture'])->where('patient_id',$patient->user_id)->latest()->get();
        $newAffiliations = collect($contrat->contrat);
        foreach($affiliations as $affiliation){
            $newAffiliation = new \stdClass();
            $newAffiliation->adresse_affilie = $affiliation->patient->user->adresse;
            $newAffiliation->ageAffilie = $affiliation->patient->age;
            $newAffiliation->bornAroundAffilie = $affiliation->patient->date_de_naissance;
            $newAffiliation->bornAroundSouscripteur = $affiliation->souscripteur->date_de_naissance;
            $newAffiliation->canal = "Website";
            $newAffiliation->code_promo = null;
            $newAffiliation->contrat_code = $affiliation->code_contrat;
            $newAffiliation->created_at = $affiliation->created_at;
            $newAffiliation->dateNaissanceAffilie = $affiliation->patient->date_de_naissance;
            $newAffiliation->dateNaissanceSouscripteur = $affiliation->souscripteur->date_de_naissance;
            $newAffiliation->dateSignature = $affiliation->date_signature;
            $newAffiliation->date_paiement = $affiliation->date_debut;
            $newAffiliation->decede = $affiliation->patient->user->decede;
            $newAffiliation->emailSouscripteur1 = $affiliation->patient->user->email;
            $newAffiliation->emailSouscripteur2 = null;
            $newAffiliation->etat = $affiliation->status_contrat;
            $newAffiliation->expire = $affiliation->expire;
            $newAffiliation->expire_mail_send = $affiliation->expire_email;
            $newAffiliation->id = $affiliation->id;
            $newAffiliation->lieuEtablissement = $affiliation->patient->user->ville;
            $newAffiliation->montantSouscription = ConversionEurotoXaf($affiliation->package->montant);
            $newAffiliation->nomAffilie = $affiliation->patient->user->nom;
            $newAffiliation->nomContact = $affiliation->contact_name;
            $newAffiliation->nomPatient = $affiliation->patient->user->nom;
            $newAffiliation->nomSouscripteur = $affiliation->souscripteur->user->nom;
            $newAffiliation->nom_mere = "";
            $newAffiliation->nom_pere = "";
            $newAffiliation->nombre_envoi = 0;
            $newAffiliation->paye_par_affilie = $affiliation->paye_par_affilie;
            $newAffiliation->paysResidenceAffilie = $affiliation->patient->user->pays;
            $newAffiliation->paysResidenceSouscripteur = $affiliation->souscripteur->user->pays;
            $newAffiliation->paysSouscription = $affiliation->souscripteur->user->pays;
            $newAffiliation->personneContact1 = $affiliation->contact_phone;
            $newAffiliation->personneContact2 = null;
            $newAffiliation->plaintes = $affiliation->plainte;
            $newAffiliation->prenomAffilie = $affiliation->patient->user->prenom;
            $newAffiliation->prenomContact = $affiliation->contact_firstName;
            $newAffiliation->prenomPatient = $affiliation->patient->user->prenom;
            $newAffiliation->prenomSouscripteur = $affiliation->souscripteur->user->prenom;
            $newAffiliation->reduction = "non";
            $newAffiliation->reference_paiement = null;
            $newAffiliation->renouvelle = $affiliation->renouvelle == 1 ? 'oui' : 'non';
            $newAffiliation->sexeAffilie =  $affiliation->patient->sexe;
            $newAffiliation->sexePatient =  $affiliation->patient->sexe;
            $newAffiliation->sexeSouscripteur =  $affiliation->souscripteur->sexe;
            $newAffiliation->slug = $affiliation->slug;
            $newAffiliation->statut_paiement =  $affiliation->status_paiement;
            $newAffiliation->telephoneAffilie1 = $affiliation->patient->user->telephone;
            $newAffiliation->telephoneAffilie2 =  null;
            $newAffiliation->telephoneSouscripeur1 = $affiliation->souscripteur->user->telephone;
            $newAffiliation->telephoneSouscripeur2 =  null;
            $newAffiliation->typeSouscription =  $affiliation->nom;
            $newAffiliation->type_paiement =  null;
            $newAffiliation->updated_at = $affiliation->updated_at;
            $newAffiliation->urgence = $affiliation->niveau_urgence;
            $newAffiliation->villeResidenceAffilie = $affiliation->patient->user->ville;
            $newAffiliation->villeResidenceSouscripteur = $affiliation->souscripteur->user->ville;
            $newAffiliation->visiteur = "NON";
            $newAffiliation->cim = $affiliation->package->description_fr;
            $newAffiliation->changes = DB::table('model_changes_history')->where(['model_id' => $affiliation->id, 'model_type' => 'App\Models\Affiliation'])->orderBy('created_at', 'desc')->get(['changes']);

            $newAffiliations->push($newAffiliation);

        }

       return response()->json(["cim" => $newAffiliations->sortByDesc('updated_at'), "dossier" => $dossier, "patient" => $patient, 'activites' => $array, 'affiliations' => $affiliations, 'referent' => $referentArray]);
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

    public function changeEtat($id)
    {
        $ligneDeTemps = LigneDeTemps::whereId($id)->first();

        if ($ligneDeTemps != null){

            $ligneDeTemps->etat = $ligneDeTemps->etat== 1 ? 0 : 1;
            $ligneDeTemps->save();
            return response()->json(["etat" => $ligneDeTemps]);
        }
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

    public function showConsultation($ligne_temp_id){
        $consultations = ConsultationMedecineGenerale::with(['motifs', 'etablissement'])->where('ligne_de_temps_id', $ligne_temp_id)->latest()->get()->transform(function ($item, $key) {
            $consultation = new \stdClass();
            $consultation->id = $item->id;
            $consultation->date_consultation = $item->date_consultation;
            $consultation->etablissement = $item->etablissement->name;

            $consultation->motifs = $item->motifs->implode('description', ', ');
            return $consultation;
        });
        return response()->json($consultations);
    }
    public function listingPatient($slug){
        $dossier = DossierMedical::where('slug', $slug)->first();
        $ligne_temps = LigneDeTemps::with(['motifs:id,description', 'motif:id,description', 'cloture'])->where('dossier_medical_id', $dossier->id)->latest()->get();
        foreach($ligne_temps as $ligne){
            if(is_null($ligne->cloture)){
                $ligne->cloture()->create([]);
            }
        }
        return response()->json($ligne_temps);
    }

}
