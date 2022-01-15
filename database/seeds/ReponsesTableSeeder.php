<?php

use Illuminate\Database\Seeder;

class ReponsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = \App\Models\Patient::all();

        foreach ($patients as $patient){
            if (!is_null($patient->user->questionSecrete)){
               $reponse = $patient->user->questionSecrete;
               $reponse->deleted_at = \Carbon\Carbon::now()->format('Y-m-d');
               $reponse->save();
            }
            \App\Models\ReponseSecrete::create([
                'user_id'=>$patient->user_id,
                'question_id'=>2,
                'reponse'=>'Medicasure',
                'slug'=>\Carbon\Carbon::now()->timestamp
            ]);
        }
    }
}
