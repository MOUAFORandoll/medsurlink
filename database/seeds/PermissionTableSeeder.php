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
        //role pour superAdmin
           'Super Administrer les roles & permissions',
           'Administrer les roles & permissions',
        //Patient
           'Consulter profils patient',
           'Creer patients',
           'Modifier patients',
           'Supprimer patients',
           'Consulter patients',
        //Consultations archivees
           'Consulter consultations archivees',
        //Consultations
           'Imprimer consultations',
           'Consulter consultations',
           'Creer consultations',
           'Modifier consultations',
           'Supprimer consultations',
           'Transmettre consultation',
           'Consulter consultations transmises',
           'Archiver consultations transmises',   
        //Rapports
           'Imprimer rapports medicaux',
        //profils souscripteur 
           'Consulter profils souscripteur',
         //profils praticien   
           'Consulter profils praticien',
        //Resultats laboratoire
           'Consulter resultats laboratoire',
           'Creer résultats laboratoire',
           'Modifier resultats laboratoire',
           'Supprimer resultats laboratoire',
           'Transmettre resultats laboratoire', 
           'Consulter resultats laboratoire archives',  
           'Imprimer resultats laboratoire',       
           'Consulter resultats laboratoire transmises',  
           'Archiver resultats laboratoire transmises',
        //Resultats imagerie
           'Consulter resultats imagerie',
           'Creer resultats imagerie',
           'Modifier resultats imagerie',
           'Supprimer  resultats imagerie',
           'Transmettre résultats imagerie',
           'Imprimer résultats imagerie',
           'Consulter resultats imagerie archives', 
           'Imprimer resultats imagerie',
           'Consulter resultats imagerie transmises',
           'Archiver resultats imagerie transmises',
        //Profils medecin controle
           'Consulter profils medecin controle',
          
        //Profils profils utilisateurs 
           'Creer profils utilisateurs',
           'Consulter profils utilisateurs',
           'Modifier profils utilisateurs',
           'Desactiver  profils utilisateurs',
        //Profils dossier médical
           'Consulter dossier médical',
           'Creer  dossier médical',
           'Modifier dossier médical',
        //Profils souscriptions affiliations
           'Consulter souscriptions affiliations',
           'Creer souscriptions affiliations',
           'Modifier souscriptions affiliations',
        //Rendez-vous
           'Supprimer  rendez-vous',
           'Consulter souscriptions rendez-vous',
           'Creer souscriptions rendez-vous',
           'Modifier souscriptions rendez-vous',
        //e-prescriptions   
           'Supprimer  e-prescriptions',
           'Consulter souscriptions e-prescriptions',
           'Creer souscriptions e-prescriptions',
           'Modifier souscriptions e-prescriptions',
        //Téléconsultation
           'Supprimer Téléconsultation',
           'Consulter Téléconsultation',
           'Creer Téléconsultation',
           'Modifier Téléconsultation',
        //Monitoring des paramètres
           'Monitoring des paramètres',
        //Recommandation
           'Supprimer  Recommandation',
           'Creer  Recommandation',
           'Consulter  Recommandation',
           'Modifier  Recommandation',
        //Chat
           'Accéder au Chat',
        //Parcours de soins
           'Accéder au Parcours de soins',
        //Géolocalisation
           'Géolocalisez',
        //souscriptions assureurs
           'Creer souscriptions assureurs',
           'Modifier souscriptions assureurs',
           'Desactiver souscriptions assureurs',
        //validation
           'Effectuer validation financieres',
           'Effectuer validation médical',
        //Formations
           'Creer formations',
           'Modifier formations',
           'Supprimer formations',
           'Consulter formations',
        //Avis-medicaux
           'Creer avis-medicaux',
           'Modifier avis-medicaux',
           'Supprimer avis-medicaux',
           'Consulter avis-medicaux',
        //Comptable
           'Creer comptable',
           'Modifier comptable',
           'Supprimer comptable',
           'Consulter comptable',
           'Creer souscripteur',
           'Modifier souscripteur',
           'Supprimer souscripteur',
        //Partenaires   
           'Creer partenaires',
           'Modifier partenaires',
           'Supprimer partenaires',
           'Consulter partenaires',
        //Association
           'Creer association',
           'Modifier association',
           'Supprimer association',
           'Consulter association',
        //Activite
           'Creer activite',
           'Modifier activite',
           'Consulter activite patients',
        ];


        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
