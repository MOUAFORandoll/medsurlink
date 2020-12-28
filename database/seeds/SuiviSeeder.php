<?php

use Illuminate\Database\Seeder;

class SuiviSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suivis = \App\Models\Suivi::all();

        foreach ($suivis as $suivi) {
            if (is_null($suivi->categorie_id)){
                $suivi->categorie_id = 1;
                $suivi->save();
            }
        }
    }
}
