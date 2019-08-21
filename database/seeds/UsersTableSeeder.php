<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'admin',
            'prenom'=>'admin',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'admin@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'admin-1'
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'1',
            'model_type'=>'App\User',
            'model_id'=>'1',
        ]);




    }
}
