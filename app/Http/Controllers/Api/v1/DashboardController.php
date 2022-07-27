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
use App\Models\MedecinControle;
use App\Models\Patient;
use App\Models\Praticien;
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
        /* $ = User::orderBy('name', 'desc')
                
                ->having('count', '>', 100)
                ->get(); */
        //$nbre_souscripteurs_par_ville = User::has('souscripteur')->groupBy('ville')->get(['id', 'ville']);
        //$nbre_souscripteurs_par_ville = User::has('souscripteur')->select("ville", DB::raw("count('id') as user_count"))->groupBy('ville');
        /* $nbre_souscripteurs_par_ville = User::has('souscripteur')
        ->select("*")
        ->orderBy('created_at', 'desc')
        ->groupBy('ville')
        ->get(); */
        //dd($nbre_souscripteurs_par_ville);
        
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
        ]);
    }

}