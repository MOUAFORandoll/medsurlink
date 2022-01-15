<?php

use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['nom'=>'PEC en attente','icon'=>'fa-hourglass-half'],
            ['nom'=>'consultation','icon'=>'fa-medkit'],
            ['nom'=>'laboratoire','icon'=>'fa-flask'],
            ['nom'=>'imagerie','icon'=>'fa-images'],
            ['nom'=>'hospitalisation','icon'=>'fa-thermometer-half'],
            ['nom'=>'domicile','icon'=>'fa-home'],
        ];

        foreach ($categories as $category){
            \App\Models\Categories::create(['nom'=>$category['nom'],'icon'=>$category['icon'],'slug'=>$category['nom'].'-'.now()->timestamp]);
        }
    }
}
