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
        \Spatie\Permission\Models\Role::create([
            'name' => 'Comptable',
            'guard_name'=>'api'
        ]);
    }
}
