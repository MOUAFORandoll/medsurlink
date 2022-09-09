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
                "temps_moyen" => mt_rand(0, 7776000),
                "affiliation_et_affectation_medecin_referents" => mt_rand(0, 7776000),
                "consultation_medecine_generale" => mt_rand(0, 7776000),
                "consultation_fichier" => mt_rand(0, 7776000),
                "resultat_labo" => mt_rand(0, 7776000),
                "resultat_imagerie" => mt_rand(0, 7776000),
                "avis_medicals" => mt_rand(0, 7776000),
                "medecin_controle" => mt_rand(0, 7776000),
                "consultation_examen_validation" => mt_rand(0, 7776000),
                "activite_amas" => mt_rand(0, 7776000),
                "nbre_patients" => mt_rand(0, 7776000),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            $metrique = Metrique::whereDate('created_at', date('Y-m-d'))->first();
        }

        $created_at = Carbon::parse($metrique->created_at);
        for ($i=1; $i <= 1000; $i++) { 
            // 2022-09-09 07:47:39
            $new_created_at = $created_at->subDays(1)->format('Y-m-d');
            $exist = Metrique::whereDate('created_at', $created_at)->first();
            if(is_null($exist)){
                DB::table('metriques')->insert([
                    "temps_moyen" => mt_rand(0, 7776000),
                    "affiliation_et_affectation_medecin_referents" => mt_rand(0, 7776000),
                    "consultation_medecine_generale" => mt_rand(0, 7776000),
                    "consultation_fichier" => mt_rand(0, 7776000),
                    "resultat_labo" => mt_rand(0, 7776000),
                    "resultat_imagerie" => mt_rand(0, 7776000),
                    "avis_medicals" => mt_rand(0, 7776000),
                    "medecin_controle" => mt_rand(0, 7776000),
                    "consultation_examen_validation" => mt_rand(0, 7776000),
                    "activite_amas" => mt_rand(0, 7776000),
                    "nbre_patients" => mt_rand(0, 7776000),
                    "created_at" => $new_created_at,
                    "updated_at" => $new_created_at
                ]);
            }
        }

    }
}
