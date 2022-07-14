<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActiviteAmaPatient;
use App\Models\ActivitesControle;
use App\Models\Affiliation;
use App\Models\DossierMedical;
use App\Models\LigneDeTemps;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class ParcourDeSoinController extends Controller
{
    /**
     * recupération des affiliations du dossier medical courant
     */
    public function affiliations($dossier_medical_slug){

        $dossier = DossierMedical::whereSlug($dossier_medical_slug)->first();

        $patient = Patient::where('user_id', $dossier->patient_id)->first();

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

        return response()->json(['affiliations' => $newAffiliations]);
    }

    /**
     * Listing des activités par affiliation et par ligne de temps des amas
     */
    public function activite_amas($dossier_medical_slug){

        $dossier = DossierMedical::whereSlug($dossier_medical_slug)->first();

        $patient_id = $dossier->patient_id;

        $activite_ama_isoles = ActiviteAmaPatient::doesntHave('affiliation')->with(['activitesAma:id,description_fr,created_at', 'updatedBy', 'createur:id,nom,prenom', 'ligne_temps:id,date_consultation,motif_consultation_id', 'ligne_temps.motif:id,description', 'etablissement:id,name'])->where('patient_id', $patient_id)->orderBy('updated_at', 'desc')->get(['id', 'activite_ama_id', 'commentaire', 'creator', 'ligne_temps_id', 'etablissement_id', 'created_at']);
        /**
         * ici nous retournons la liste des affiliations avec lignes de temps associées et pour chaque ligne de temps, ses activités AMA
         */
        $activite_ama_manuelles = Affiliation::with(['cloture', 'package:id,description_fr', 'ligneTemps.motif:id,description', 'ligneTemps.cloture', 'ligneTemps.activites_ama_patients.activitesAma:id,description_fr', 'ligneTemps.activites_ama_patients' => function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        }])->where('patient_id',$patient_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);

        $rdata = Affiliation::has('ligneTemps.rendezVous')->with(['package:id,description_fr'])->where('patient_id', $patient_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);
        $activite_ama_automatiques = collect();
        foreach($rdata as $affiliation){
            $ligne_temps = LigneDeTemps::with(['rendezVous.etablissement:id,name', 'rendezVous.praticien:id,nom,prenom', 'motif:id,description'])->where('affiliation_id', $affiliation->id)->orderBy('updated_at', 'desc')->get();
            $affiliation->ligne_temps = $ligne_temps;
            $activite_ama_automatiques->push($affiliation);
        }
        
        return response()->json(['activite_ama_isoles' => $activite_ama_isoles, 'activite_ama_manuelles' => $activite_ama_manuelles, 'activite_ama_automatiques' => $activite_ama_automatiques]);

    }

    /**
    * Listing des activités par affiliation et par ligne de temps du médécin reférent (contrôle)
    */

    public function activite_medecin_referents($dossier_medical_slug){
        $dossier = DossierMedical::whereSlug($dossier_medical_slug)->first();
        $patient_id = $dossier->patient_id;
        $activites_medecin_referent_isoles = ActivitesControle::doesntHave('affiliation')->with(['activitesMedecinReferent:id,description_fr','updatedBy','createur:id,nom,prenom', 'ligne_temps:id,date_consultation,motif_consultation_id', 'ligne_temps.motif:id,description', 'etablissement:id,name'])->where('patient_id',$patient_id)->orderBy('updated_at', 'desc')->get(['id', 'activite_id', 'creator', 'ligne_temps_id', 'etablissement_id', 'created_at']);
        $activites_medecin_referent_manuelles = Affiliation::with(['cloture', 'package:id,description_fr', 'ligneTemps.motif:id,description', 'ligneTemps', 'ligneTemps.activites_referent_patients.activitesMedecinReferent:id,description_fr', 'ligneTemps.activites_referent_patients' => function ($query) use ($patient_id) {
            $query->where('patient_id', $patient_id);
        }])->where('patient_id',$patient_id)->orderBy('updated_at', 'desc')->get(['id', 'status_paiement', 'date_signature', 'package_id']);

        return response()->json(['activites_medecin_referent_isoles' => $activites_medecin_referent_isoles, 'activites_medecin_referent_manuelles' => $activites_medecin_referent_manuelles]);
    }

}