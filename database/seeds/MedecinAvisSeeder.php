<?php

use Illuminate\Database\Seeder;

class MedecinAvisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::where('isMedicasure','1')->get();
        foreach ($users as $user){
            if (!is_null($user->praticien) || !is_null($user->medecinControle)){
                $user->isNotice='1';
                $user->save();
            }
        }
    }
}
