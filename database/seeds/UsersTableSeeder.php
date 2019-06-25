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
            'name'=>'admin',
            'email'=>'admin@medicasure.com',
            'password'=>'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG',
        ]);

        \Illuminate\Support\Facades\DB::table('model_has_roles')->insert([
            'role_id'=>'1',
            'model_type'=>'App\User',
            'model_id'=>'1',
        ]);




    }
}
