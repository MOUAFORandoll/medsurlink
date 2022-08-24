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
            "",

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
