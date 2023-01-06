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
           'Créer patients',
           'Modifier patients',
           'Supprimer patients',
           'Consulter patients',
        //Consultations archivees
           'Consulter consultations archivees',
        //Consultations
           'Imprimer consultations',
           'Consulter consultations',
           'Créer consultations',
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
           'Créer résultats laboratoire',
           'Modifier resultats laboratoire',
           'Supprimer resultats laboratoire',
           'Transmettre resultats laboratoire', 
           'Consulter resultats laboratoire archives',  
           'Imprimer resultats laboratoire',       
           'Consulter resultats laboratoire transmises',  
           'Archiver resultats laboratoire transmises',
        //Resultats imagerie
           'Consulter resultats imagerie',
           'Créer resultats imagerie',
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
           'Créer profils utilisateurs',
           'Consulter profils utilisateurs',
           'Modifier profils utilisateurs',
           'Desactiver  profils utilisateurs',
        //Profils dossier médical
           'Consulter dossier médical',
           'Créer  dossier médical',
           'Modifier dossier médical',
        //Profils souscriptions affiliations
           'Consulter souscriptions affiliations',
           'Créer souscriptions affiliations',
           'Modifier souscriptions affiliations',
        //Rendez-vous
           'Supprimer  rendez-vous',
           'Consulter souscriptions rendez-vous',
           'Créer souscriptions rendez-vous',
           'Modifier souscriptions rendez-vous',
        //e-prescriptions   
           'Supprimer  e-prescriptions',
           'Consulter souscriptions e-prescriptions',
           'Créer souscriptions e-prescriptions',
           'Modifier souscriptions e-prescriptions',
        //Téléconsultation
           'Supprimer Téléconsultation',
           'Consulter Téléconsultation',
           'Créer Téléconsultation',
           'Modifier Téléconsultation',
        //Monitoring des paramètres
           'Monitoring des paramètres',
        //Recommandation
           'Supprimer  Recommandation',
           'Créer  Recommandation',
           'Consulter  Recommandation',
           'Modifier  Recommandation',
        //Chat
           'Accéder au Chat',
        //Parcours de soins
           'Accéder au Parcours de soins',
        //Géolocalisation
           'Géolocalisez',
        //souscriptions assureurs
           'Créer souscriptions assureurs',
           'Modifier souscriptions assureurs',
           'Desactiver souscriptions assureurs',
        //validation
           'Effectuer validation financieres',
           'Effectuer validation médical',
        //Formations
           'Créer formations',
           'Modifier formations',
           'Supprimer formations',
           'Consulter formations',
        //Avis-medicaux
           'Créer avis-medicaux',
           'Modifier avis-medicaux',
           'Supprimer avis-medicaux',
           'Consulter avis-medicaux',
        //Comptable
           'Créer comptable',
           'Modifier comptable',
           'Supprimer comptable',
           'Consulter comptable',
           'Créer souscripteur',
           'Modifier souscripteur',
           'Supprimer souscripteur',
        //Partenaires   
           'Créer partenaires',
           'Modifier partenaires',
           'Supprimer partenaires',
           'Consulter partenaires',
        //Association
           'Créer association',
           'Modifier association',
           'Supprimer association',
           'Consulter association',
        //Activite
           'Créer activite',
           'Modifier activite',
           'Consulter activite patients',
         /**
          * Gestion des alertes
          */
          'Créer une alerte',
          'Modifier une alerte',
          'Afficher une alerte',
          'Listing des alertes',
          'Supprimer une alerte',
          'Affecter un médecin controle à une alerte',
          'Rejetter une alerte',
          /* Gestion des teleconsultations
          */
          'Créer une téléconsultation',
          'Modifier une téléconsultation',
          'Afficher une téléconsultation',
          'Listing des téléconsultations',
          'Supprimer une téléconsultation',

         /* Gestion des notifications
          */
          'Listing des notifications',
          'Afficher une notification'
        ];


        foreach ($permissions as $permission) {
            $exist_permission = Permission::where('name', $permission)->first();
            if(!$exist_permission){
                Permission::create(['name' => $permission]);
            }
        }
    }
}
