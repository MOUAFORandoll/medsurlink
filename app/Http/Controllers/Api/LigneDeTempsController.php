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
        $ligneDeTemps = LigneDeTemps::create($request->validated(),['motif_consultation_id','dossier_medical_id','date_consultation', 'affiliation_id']);

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
        $activite_ama_isoles = ActiviteAmaPatient::doesntHave('ligne_temps')->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'commentaire', 'date_cloture']);

        $activite_ama_manuelles = Affiliation::with(['package:id,description_fr', 'ligneTemps.motif:id,description', 'ligneTemps', 'ligneTemps.activites_ama_patients' => function ($query) use ($patient) {
            $query->where('patient_id', $patient->user_id);
        }])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);

        $activites_referent = ActivitesControle::with(['activitesMedecinReferent','patient','updatedBy','createur'])->where('patient_id',$patient->user_id)->orderBy('updated_at', 'desc')->get();
        //Patient::with(['activitesAma','medecinReferent.createur','medecinReferent.medecinControles','rendezVous',])->where('user_id',$patient->user->id)->first();
        $rendezVous = RendezVous::where('patient_id',$patient->user_id)->latest()->get();
        $array = array('rendez_vous' =>$rendezVous,'activite_ama_isoles' =>  $activite_ama_isoles, 'activite_ama_manuelles' =>  $activite_ama_manuelles,'activites_referent' =>  $activites_referent,'examen_validation_assureur' =>  $examen_validation_assureur, 'examen_validation_medecin' =>  $examen_validation_medecin);
        $referentArray = array('referent'=> $activites_referent);


        $contrat = getContrat($patient->user);

        $affiliations = Affiliation::with(['patient.user', 'souscripteur.user', 'package'])->where('patient_id',$patient->user_id)->latest()->get();
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
