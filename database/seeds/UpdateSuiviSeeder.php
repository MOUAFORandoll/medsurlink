<?php

use Illuminate\Database\Seeder;

class UpdateSuiviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suivis = \App\Models\Suivi::whereNotNull('responsable')->get();
        foreach ($suivis as $suivi){
            \App\Models\MedecinDeSuivi::create(['suivi_id'=>$suivi->id,'user_id'=>$suivi->responsable]);
        }
    }
}
