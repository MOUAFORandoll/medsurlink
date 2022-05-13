<?php

use Illuminate\Database\Seeder;

class DictionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Extrême-Nord',
            'Nord',
            'Adamaoua',
            'Est',
            'Centre',
            'Sud',
            'Littoral',
            'Ouest',
            'Nord-Ouest',
            'Sud-Ouest',
        ];

        $categoriePartenaires = [
            'Hôpital Publique',
            'Hôpital Privé',
            'Hôpital Confessionnel',
            'Clinique',
            'Centre de santé ',
            'Laboratoire d’analyse',
            'Pharmacie',
            'Centre d’imagerie',
            'Cabinet de soins',
        ];

        foreach ($regions as $region){
            \App\Models\Dictionnaire::create([
               'fr_description'=>$region,
               'en_description'=>$region,
               'reference'=>'regions',
            ]);
        }

        foreach ($categoriePartenaires as $category){
            \App\Models\Dictionnaire::create([
               'fr_description'=>$category,
               'en_description'=>$category,
               'reference'=>'partenaire',
            ]);
        }
    }
}
