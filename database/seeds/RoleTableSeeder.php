<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'Docteur',
            'Patient',
            'Garant',
            'Partenaire',
            'Praticien',
            'Medecin controle',
            'Gestionnaire',
            'Souscripteur',
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        \Illuminate\Support\Facades\DB::table('role_has_permissions')->insert([
            'permission_id'=>1,
            'role_id'=>1
        ]);

    }
}
