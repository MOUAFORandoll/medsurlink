<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeOperationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('type_operations')->insert([
            [
                'libelle' => 'Souscription'
            ],
            [
                'libelle' => 'Affiliation'
            ],
            [
                'libelle' => 'Affectation d’un médecin référent'
            ],
            [
                'libelle' => 'Appel du patient'
            ],
            [
                'libelle' => 'Appel du souscripteur'
            ],
            [
                'libelle' => 'Téléconsultation'
            ],
            [
                'libelle' => 'Encodage sur medsurlink'
            ]
        ]);
    }
}
