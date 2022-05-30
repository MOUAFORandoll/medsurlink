<?php

use Illuminate\Database\Seeder;

class souscripteurMedicasure extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::with(['souscripteur'=>function($query){
            $query->whereNotNull('user_id');
    }])->get();
        $i=0;
        foreach ($users as $user){
          if(!is_null($user->souscripteur)){
              $user->isMedicasure = 1;
              $user->save();
          }

        }
    }
}
