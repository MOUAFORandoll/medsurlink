<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActiviteAmaPatient;
use App\Models\ActivitesAma;
use App\Models\ActivitesControle;
use App\Models\Affiliation;
use App\Models\ConsultationExamenValidation;
use App\Models\ConsultationFichier;
use App\Models\ConsultationMedecineGenerale;
use App\Models\DossierMedical;
use App\Models\EtablissementExercice;
use App\Models\File;
use App\Models\LigneDeTemps;
use App\Models\MedecinControle;
use App\Models\Offre;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Praticien;
use App\Models\Prescription;
use App\Models\ResultatLabo;
use App\Models\Souscripteur;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function dashboard(){

        $nbre_patients = Patient::has('user')->count();
        $nbre_souscripteurs = Souscripteur::has('user')->count();
        $nbre_praticiens = Praticien::has('user')->count();
        $nbre_medecin_controles = MedecinControle::has('user')->count();
        $nbre_medecin_referents = MedecinControle::has('user')->has('patients')->count();
        $nbre_amas = User::whereHas('roles', function ($query) {
            $query->where('name', 'Assistante');
        })->count();
        $nbre_gestionnaires = User::whereHas('roles', function ($query) {
            $query->where('name', 'Gestionnaire');
        })->count();
        $nbre_admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->count();

        $nbre_users_internes = User::where('isMedicasure', 1)->count();
        $nbre_users_externes = User::where('isMedicasure', 0)->count();

        $nbre_souscripteurs_par_ville = DB::select("select users.ville, count('users.id') as nombres from model_has_roles INNER JOIN users ON model_has_roles.model_id = users.id WHERE users.deleted_at IS NULL AND model_has_roles.role_id = 3 GROUP BY users.ville ORDER BY COUNT('users.id') DESC");
        $nbre_souscripteurs_par_pays = DB::select("select users.pays, count('users.id') as nombres from model_has_roles INNER JOIN users ON model_has_roles.model_id = users.id WHERE users.deleted_at IS NULL AND model_has_roles.role_id = 3 GROUP BY users.ville ORDER BY COUNT('users.id') DESC");
        
        $nbre_patient_par_ville =  DB::select("select users.ville, count('users.id') as nombres from model_has_roles INNER JOIN users ON model_has_roles.model_id = users.id WHERE users.deleted_at IS NULL AND model_has_roles.role_id = 2 GROUP BY users.ville ORDER BY COUNT('users.id') DESC");
        $nbre_patient_par_pays = DB::select("select users.pays, count('users.id') as nombres from model_has_roles INNER JOIN users ON model_has_roles.model_id = users.id WHERE users.deleted_at IS NULL AND model_has_roles.role_id = 2 GROUP BY users.ville ORDER BY COUNT('users.id') DESC");
        $nbre_affiliations_janvier_juin = Affiliation::where('status_paiement', 'PAYE')->whereDate('created_at', '>=', '2022-01-01')->whereDate('created_at', '<=', '2022-06-30')->count();
        $nbre_cim_janvier_juin = countContrats()->nbre_affiliations_janvier_juin;
        $nbre_affiliation_par_offres = Package::select(['id', 'description_fr'])->withCount(['affiliations' => function ($query) {
            $query->where('status_paiement', 'PAYE');
        }])->get();

        $nbre_offres = Package::count();
        $donnes_comparative_par_offres = Offre::with('packages.items')->get();
        $nbre_offre_par_villes = DB::select("select users.ville, count('users.id') as nombres from affiliations INNER JOIN users ON affiliations.patient_id = users.id WHERE users.deleted_at IS NULL GROUP BY users.ville ORDER BY COUNT('users.id') DESC;");
        $nbre_offre_par_pays = DB::select("select users.pays, count('users.id') as nombres from affiliations INNER JOIN users ON affiliations.patient_id = users.id WHERE users.deleted_at IS NULL GROUP BY users.pays ORDER BY COUNT('users.id') DESC;");
        $nbre_ligne_temps = LigneDeTemps::count();
        $nbre_activite_amas = ActivitesAma::count();
        $nbre_activite_controle = ActivitesControle::count();
        $nbre_validations = ConsultationExamenValidation::count();
        $nbre_consultation_medecine_generale = DB::table('consultation_medecine_generales')->whereNull('deleted_at')->count();
        $nbre_allergies = DB::table('allergies')->whereNull('deleted_at')->count();
        $traitement_actuels = DB::table('traitement_actuels')->whereNull('deleted_at')->count();
        $nbre_prescriptions = Prescription::count();
        $nbre_resultat_laboratoire = DB::table('resultat_labos')->whereNull('deleted_at')->count();
        $nbre_resultat_imageries = DB::table('resultat_imageries')->whereNull('deleted_at')->count();
        $nbre_hospitalisations = DB::table('hospitalisations')->whereNull('deleted_at')->count(); 
        $fichier_medico_externes = File::count();
        $nbre_dossier_medicaux = DossierMedical::has('patient')->count();
        $nbre_compte_rendu_operatoires = DB::table('compte_rendu_operatoires')->whereNull('deleted_at')->count(); 
        $nbre_avis = DB::table('avis')->whereNull('deleted_at')->count(); 
        $nbre_medecin_avis = DB::table('medecin_avis')->whereNull('deleted_at')->count(); 
        $nbre_rendez_vous = DB::table('rendez_vous')->whereNull('deleted_at')->count(); 

        $nbre_rendez_vous_par_patients = User::select(['id'])->with('dossier')->has('rendezVous')->has('patient')->withCount('rendezVous')->get();
        $nbre_rendez_vous_par_praticiens = Praticien::select(['numero_ordre'])->has('rendezVous')->withCount('rendezVous')->get();
        $nbre_rendez_vous_par_medecin_referents = User::select(['nom', 'prenom', 'ville', 'telephone'])->has('rendezVous')->has('medecinControle')->withCount('rendezVous')->get();
        $nbre_patient_avec_medecin_referents = User::select(['nom', 'prenom', 'ville', 'telephone'])->has('patient.medecinReferent')->count();
        $nbre_medecin_referent_has_patients = MedecinControle::with('user:id,nom,prenom')->with('patients')->get(/* ['user_id'] */);
        $nbre_patient_decedes = Patient::whereHas('user', function ($query) { $query->where('decede', 'oui'); })->count();

        return response()->json([
            'nbre_patients' => $nbre_patients, 
            'nbre_souscripteurs' => $nbre_souscripteurs, 
            'nbre_praticiens' => $nbre_praticiens, 
            'nbre_medecin_controles' => $nbre_medecin_controles,
            'nbre_amas' => $nbre_amas,
            'nbre_gestionnaires' => $nbre_gestionnaires,
            'nbre_admins' => $nbre_admins,
            'nbre_users_internes' => $nbre_users_internes,
            'nbre_users_externes' => $nbre_users_externes,
            'nbre_souscripteurs_par_ville' => $nbre_souscripteurs_par_ville,
            'nbre_souscripteurs_par_pays' => $nbre_souscripteurs_par_pays,
            'nbre_patient_par_ville' => $nbre_patient_par_ville,
            'nbre_patient_par_pays' => $nbre_patient_par_pays,
            'nbre_affiliations_janvier_juin' => $nbre_affiliations_janvier_juin,
            'nbre_cim_janvier_juin' => $nbre_cim_janvier_juin,
            'nbre_affiliation_par_offres' => $nbre_affiliation_par_offres,
            'nbre_offres' => $nbre_offres,
            'donnes_comparative_par_offres' => $donnes_comparative_par_offres,
            'nbre_offre_par_villes' => $nbre_offre_par_villes,
            'nbre_offre_par_pays' => $nbre_offre_par_pays,
            'nbre_ligne_temps' => $nbre_ligne_temps,
            'nbre_activite_amas' => $nbre_activite_amas,
            'nbre_activite_controle' => $nbre_activite_controle,
            'nbre_validations' => $nbre_validations,
            'nbre_consultation_medecine_generale' => $nbre_consultation_medecine_generale,
            'nbre_allergies' => $nbre_allergies,
            'traitement_actuels' => $traitement_actuels,
            'nbre_prescriptions' => $nbre_prescriptions,
            'nbre_resultat_laboratoire' => $nbre_resultat_laboratoire,
            'nbre_resultat_imageries' => $nbre_resultat_imageries,
            'nbre_hospitalisations' => $nbre_hospitalisations,
            'fichier_medico_externes' => $fichier_medico_externes,
            'nbre_dossier_medicaux' => $nbre_dossier_medicaux,
            'nbre_compte_rendu_operatoires' => $nbre_compte_rendu_operatoires,
            'nbre_avis' => $nbre_avis,
            'nbre_medecin_avis' => $nbre_medecin_avis,
            'nbre_rendez_vous' => $nbre_rendez_vous,
            'nbre_rendez_vous_par_patients' => $nbre_rendez_vous_par_patients,
            'nbre_rendez_vous_par_praticiens' => $nbre_rendez_vous_par_praticiens,
            'nbre_rendez_vous_par_medecin_referents' => $nbre_rendez_vous_par_medecin_referents,
            //'nombre_etablissement_exercices' => $nombre_etablissement_exercices,
            'nbre_patient_avec_medecin_referents' => $nbre_patient_avec_medecin_referents,
            'nbre_medecin_referent_has_patients' => $nbre_medecin_referent_has_patients,
            'nbre_patient_decedes' => $nbre_patient_decedes,
            'nbre_medecin_referents' => $nbre_medecin_referents


        ]);
    }

}