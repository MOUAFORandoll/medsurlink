<?php

use Illuminate\Database\Seeder;

class ActivitesAmaOtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $automatiques = [
            "",
        ];
        $manuelles = [
            "Appel du souscripteur après l'affiliation",
            "Appel du patient après l'affiliation",
            "obtention du dossier physique du patient
            pour encodage ( compte rendu, CD)",
            "organisation de l\'obtention des médicaments
            du patient",
            "organisation discussion pluridisciplinaire",
            "organisation d'une prestation à domicile ",
            "encodage données medicales",
            "reception d'une allerte par le souscripteur",
            "reception d'une alerte par la personne de contact"
        ];
        foreach ($automatiques as $automatique){
            \App\Models\ActivitesAma::create([
               'description_fr'=>$automatique,
               'description_en'=>$automatique,
               'type'=> 'AUTOMATIQUE',
            ]);
        }

        foreach ($manuelles as $manuelle){
            \App\Models\ActivitesAma::create([
               'description_fr'=>$manuelle,
               'description_en'=>$manuelle,
               'type'=> 'MANUELLE',
            ]);
        }
    }
}
