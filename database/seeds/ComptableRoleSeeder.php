<?php

use Illuminate\Database\Seeder;

class ComptableRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \Spatie\Permission\Models\Role::whereName('Comptable')->first();
        $role->name = 'Etablissement';
        $role->save();

        \Spatie\Permission\Models\Role::create([
            'name' => 'Comptable',
            'guard_name'=>'api'
        ]);

    }
}
