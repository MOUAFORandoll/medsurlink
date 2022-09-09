<?php

use App\Models\Metrique;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetriquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metrique = Metrique::whereDate('created_at', date('Y-m-d'))->first();
        if(is_null($metrique)){
            DB::table('metriques')->insert([
                "temps_moyen" => mt_rand(),
                "affiliation_et_affectation_medecin_referents" => mt_rand(),
                "consultation_medecine_generale" => mt_rand(),
                "consultation_fichier" => mt_rand(),
                "resultat_labo" => mt_rand(),
                "resultat_imagerie" => mt_rand(),
                "avis_medicals" => mt_rand(),
                "medecin_controle" => mt_rand(),
                "consultation_examen_validation" => mt_rand(),
                "activite_amas" => mt_rand(),
                "date_recuperation" => now(),
                "nbre_patients" => mt_rand(),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            $metrique = Metrique::whereDate('created_at', date('Y-m-d'))->first();
        }

        $created_at = new Carbon($metrique->created_at);
        \Log::alert($created_at);
        for ($i=1; $i <= 1000; $i++) { 
            // 2022-09-09 07:47:39
            $created_at = $created_at->subDays($i)->format('Y-m-d');
            /* $exist = Metrique::whereDate('created_at', $created_at)->first();
            if(is_null($exist)){
                DB::table('metriques')->insert([
                    "temps_moyen" => mt_rand(),
                    "affiliation_et_affectation_medecin_referents" => mt_rand(),
                    "consultation_medecine_generale" => mt_rand(),
                    "consultation_fichier" => mt_rand(),
                    "resultat_labo" => mt_rand(),
                    "resultat_imagerie" => mt_rand(),
                    "avis_medicals" => mt_rand(),
                    "medecin_controle" => mt_rand(),
                    "consultation_examen_validation" => mt_rand(),
                    "activite_amas" => mt_rand(),
                    "date_recuperation" => now(),
                    "nbre_patients" => mt_rand(),
                    "created_at" => $created_at,
                    "updated_at" => $created_at
                ]);
            } */
        }

    }
}
