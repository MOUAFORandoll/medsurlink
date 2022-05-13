<?php

use Illuminate\Database\Seeder;

class PecSuiviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suivis = \App\Models\Suivi::all();
        $suiviSeederId = $suivis->pluck('dossier_medical_id')->toArray();
        $dossiersMedicaux=\App\Models\DossierMedical::all();
        $dossiersMedicauxId = $dossiersMedicaux->pluck('id')->toArray();
        $nonSuivis = array_diff($dossiersMedicauxId, $suiviSeederId);

        foreach ($nonSuivis as $nonSuivi){
            \App\Models\Suivi::create([
                'dossier_medical_id'=>$nonSuivi,
                'motifs'=>'Prise en charge initiale en attente',
                'categorie_id'=>'1'
            ]);
        }
    }
}
