<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'Administrer les roles & permissions',
           'Consulter profils patient',
           'Consulter consultations archivees',
           'Consulter resultats laboratoire archives',
           'Consulter resultats imagerie archives',
           'Imprimer rapports medicaux',
           'Imprimer resultats laboratoire',
           'Imprimer resultats imagerie',
           'Consulter profils souscripteur',
           'Imprimer consultations',
           'Consulter profils praticien',
           'Consulter consultations',
           'Creer consultations',
           'Modifier consultations',
           'Supprimer consultations',
           'Transmettre consultation',
           'Consulter resultats laboratoire',
           'Creer résultats laboratoire',
           'Modifier resultats laboratoire',
           'Supprimer resultats laboratoire',
           'Transmettre resultats laboratoire',
           'Consulter resultats imagerie',
           'Creer resultats imagerie',
           'Modifier resultats imagerie',
           'Supprimer  resultats imagerie',
           'Transmettre résultats imagerie',
           'Imprimer résultats imagerie',
           'Consulter profils medecin controle',
           'Consulter consultations transmises',
           'Consulter resultats laboratoire transmises',
           'Consulter resultats imagerie transmises',
           'Archiver consultations transmises',
           'Archiver resultats laboratoire transmises',
           'Archiver resultats imagerie transmises',
           'Creer profils utilisateurs',
           'Consulter profils utilisateurs',
           'Modifier profils utilisateurs',
           'Desactiver  profils utilisateurs',
           'Consulter dossier médical',
           'Creer  dossier médical',
           'Modifier dossier médical',
           'Consulter souscriptions affiliations',
           'Creer souscriptions affiliations',
           'Modifier souscriptions affiliations',
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
