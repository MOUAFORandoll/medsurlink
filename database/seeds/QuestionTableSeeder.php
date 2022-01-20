<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'intitule' => 'Quel est le nom de votre père',
            'slug' => 'slug01',
        ]);

        DB::table('questions')->insert([
            'intitule' => 'Quel est le nom de votre mère',
            'slug' => 'slug02',
        ]);
    }
}
