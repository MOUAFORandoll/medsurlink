<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            UsersTableSeeder::class,
            MotifsTableSeeder::class,
            QuestionTableSeeder::class,
            ReponsesTableSeeder::class,
            MedicamentsTableSeeder::class,
            MedecinAvisSeeder::class,
            PrestationsCliniqueKutendaMedicalTableSeeder::class,
            ComptableRoleSeeder::class,
            AnamnesesSeesder::class,
            ExamenClinicSeesder::class
        ]);
    }
}
