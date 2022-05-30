<?php

use Illuminate\Database\Seeder;

class ApiAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'SmartWorld Api authentification ',
            'prenom'=>'Request user',
            'email'=>'CuPjYppNBPMjuNHUjVsc2fqRmS4ARwEJPHHpKW8FmTFKkZhtFbJe5DGZB48D49tk',
            'password'=>\Illuminate\Support\Facades\Hash::make('wtEDdrkcMZSyvHwbdrN29dWfbpPA44bbHHpjJeevhDksnYHvNcVr5J4G7LDJVBG4'),
            'nationalite'=>'Camerounaise',
            'pays'=>'Cameroun',
            'slug'=>'CuPjYppNBPMju2',
            'telephone'=>'23775066919',
            'created_at'=>'2020-11-18',
            'updated_at'=>'2020-11-18'
        ]);
    }
}
