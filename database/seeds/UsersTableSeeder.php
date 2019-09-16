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
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'patient',
            'prenom'=>'patient',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'patient@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'patient-1'
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'souscripteur',
            'prenom'=>'souscripteur',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'souscripteur@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'souscripteur-1'
        ]);

        \Illuminate\Support\Facades\DB::table('souscripteurs')->insert([
            'user_id'=>3,
            'sexe'=>'M',
            'date_de_naissance'=>'1996-09-02',
            'age'=>'22',
            'slug'=>'souscripteur-1',
        ]);

        \Illuminate\Support\Facades\DB::table('patients')->insert([
            'user_id'=>2,
            'souscripteur_id'=>3,
            'date_de_naissance'=>'1996-09-02',
            'age'=>'22',
            'slug'=>'patient-1-1',
            'sexe'=>'M',
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'praticien',
            'prenom'=>'praticien',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'praticien@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'praticien-1'
        ]);
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'controle',
            'prenom'=>'medecin',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'medecin@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'medecin-controle-1'
        ]);
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'nom'=>'gestionnaire',
            'prenom'=>'gestionnaire',
            'nationalite'=>'Camerounaise',
            'quartier'=>'Akwa',
            'code_postal'=>'4615',
            'ville'=>'Douala',
            'pays'=>'Cameroun',
            'telephone'=>'698900294',
            'email'=>'gestionnaire@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
            'slug'=>'gestionnaire-1'
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
        'role_id'=>'1',
        'model_type'=>'App\User',
        'model_id'=>'1',
    ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'2',
            'model_type'=>'App\User',
            'model_id'=>'2',
        ]);



        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'3',
            'model_type'=>'App\User',
            'model_id'=>'3',
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'4',
            'model_type'=>'App\User',
            'model_id'=>'4',
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'5',
            'model_type'=>'App\User',
            'model_id'=>'5',
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'6',
            'model_type'=>'App\User',
            'model_id'=>'6',
        ]);




    }
}
