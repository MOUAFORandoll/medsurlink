<?php

use Illuminate\Database\Seeder;

class GroupeActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gaArray = [
            'Processus de suivi d’un Patient affilié – Medicasure à CHAUD (J1)',
            'Processus de suivi d’un Patient affilié – Medicasure à FROID (Après l’évènement aigu à l’exception des consultations à domicile)',
            'Expansion du réseau – Partenaire Medicasure et Contrôle Qualité',
            'Promotion scientifique '
        ];

        foreach ($gaArray as $item){
            \App\Models\GroupeActivite::create(['nom'=>$item]);
        }
    }
}
