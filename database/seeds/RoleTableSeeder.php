<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Row;
use  \Spatie\Permission\Models\Role;
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
            'Super Admin',
            'Admin',
            'Patient',
            'Souscripteur',
            'Praticien',
            'Medecin controle',
            'Gestionnaire',
            'Docteur',
            'Garant',
            'Partenaire',
            'Etablissement',
            'Comptable',
            'Assistante',
            'Pharmacien',
            'Assureur',
            'Association',
            'Directeur'
        ];

        foreach ($roles as $role) {
            $exist_role = Role::where('name', $role)->first();
            if(!$exist_role){
                Role::create([
                    'name' => $role,
                    'guard_name'=>'api'
                ]);
            }
        }

        //Definition des permissions du super-admin
        // $this->setPermissionRole(1,1);

//        Definition des permissions de l'admin
        $this->setPermissionRole(1,1);

//        Definition des permissions du patient
         $this->setPermissionRole(2,2);
         $this->setPermissionRole(3,2);
         $this->setPermissionRole(4,2);
         $this->setPermissionRole(5,2);
         $this->setPermissionRole(6,2);
         $this->setPermissionRole(7,2);
         $this->setPermissionRole(8,2);
         $this->setPermissionRole(101,2);
         $this->setPermissionRole(102,2);
         $this->setPermissionRole(103,2);
         $this->setPermissionRole(104,2);
         $this->setPermissionRole(105,2);
         $this->setPermissionRole(113, 2);
         $this->setPermissionRole(114, 2);

//       Definition des permissions du souscripteur
        $this->setPermissionRole(2,3);
        $this->setPermissionRole(9,3);
        $this->setPermissionRole(3,3);
        $this->setPermissionRole(4,3);
        $this->setPermissionRole(5,3);
        $this->setPermissionRole(10,3);
        $this->setPermissionRole(7,3);
        $this->setPermissionRole(8,3);
        $this->setPermissionRole(101,3);
        $this->setPermissionRole(102,3);
        $this->setPermissionRole(103,3);
        $this->setPermissionRole(104,3);
        $this->setPermissionRole(105,3);
        $this->setPermissionRole(113, 3);
        $this->setPermissionRole(114, 3);

//        Definition des permissions du praticien
        $this->setPermissionRole(2,4);
        $this->setPermissionRole(11,4);
        $this->setPermissionRole(12,4);
        $this->setPermissionRole(13,4);
        $this->setPermissionRole(14,4);
        $this->setPermissionRole(15,4);
        $this->setPermissionRole(16,4);
        $this->setPermissionRole(10,4);
        $this->setPermissionRole(17,4);
        $this->setPermissionRole(18,4);
        $this->setPermissionRole(19,4);
        $this->setPermissionRole(20,4);
        $this->setPermissionRole(21,4);
        $this->setPermissionRole(7,4);
        $this->setPermissionRole(22,4);
        $this->setPermissionRole(23,4);
        $this->setPermissionRole(24,4);
        $this->setPermissionRole(25,4);
        $this->setPermissionRole(26,4);
        $this->setPermissionRole(27,4);
        $this->setPermissionRole(113, 4);
        $this->setPermissionRole(114, 4);

//        Definition des permissions du medecin controle
        $this->setPermissionRole(2,5);
        $this->setPermissionRole(28,5);
        $this->setPermissionRole(29,5);
        $this->setPermissionRole(30,5);
        $this->setPermissionRole(31,5);
        $this->setPermissionRole(32,5);
        $this->setPermissionRole(33,5);
        $this->setPermissionRole(34,5);

        $this->setPermissionRole(103, 5);
        $this->setPermissionRole(104, 5);
        $this->setPermissionRole(108, 5);
        $this->setPermissionRole(109, 5);
        $this->setPermissionRole(110, 5);
        $this->setPermissionRole(111, 5);
        $this->setPermissionRole(112, 5);
        $this->setPermissionRole(113, 5);
        $this->setPermissionRole(114, 5);


//        Definition des permissions du gestionnaire
        $this->setPermissionRole(35,6);
        $this->setPermissionRole(36,6);
        $this->setPermissionRole(37,6);
        $this->setPermissionRole(38,6);
        $this->setPermissionRole(39,6);
        $this->setPermissionRole(40,6);
        $this->setPermissionRole(41,6);
        $this->setPermissionRole(42,6);
        $this->setPermissionRole(43,6);
        $this->setPermissionRole(44,6);
        $this->setPermissionRole(113, 6);
        $this->setPermissionRole(114, 6);



//     Définition des permissions des assistantes

        $this->setPermissionRole(101,12);
        $this->setPermissionRole(102,12);
        $this->setPermissionRole(103,12);
        $this->setPermissionRole(104,12);
        $this->setPermissionRole(105,12);
        $this->setPermissionRole(106,12);
        $this->setPermissionRole(107,12);
        $this->setPermissionRole(113, 12);
        $this->setPermissionRole(114, 12);

    }

    public function setPermissionRole($permission,$role){
        $role_has_permission = DB::table('role_has_permissions')->where(['permission_id'=>$permission, 'role_id'=>$role])->first();
        if(!$role_has_permission){
            DB::table('role_has_permissions')->insert([
                'permission_id'=>$permission,
                'role_id'=>$role
            ]);
        }
    }
}
