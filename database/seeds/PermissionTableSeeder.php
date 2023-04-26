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
        'Accéder au délai de prise en charge',
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
          'Imprimer une téléconsultation',

         /* Gestion des notifications
          */
          'Listing des notifications',
          'Afficher une notification',

         /** Gestion des bulletins d'examens */
          "Créer un bulletin d'examen",
          "Modifier un bulletin d'examen",
          "Afficher un bulletin d'examen",
          "Listing des bulletins d'examens",
          "Supprimer un bulletin d'examen",
          "Imprimer un bulletin d'examen",
          "Partager un bulletin d'examen",

         /** Gestion des bons de prises en charges */
         "Créer un bon de prise en charge",
         "Modifier un bon de prise en charge",
         "Afficher un bon de prise en charge",
         "Listing des bons de prises en charges",
         "Supprimer un bon de prise en charge",
         "Imprimer un bon de prise en charge",
         "Partager un bon de prise en charge",

         /** Gestion des imageries médicales */
         "Créer une prescription imagérie",
         "Modifier une prescription imagérie",
         "Afficher une prescription imagérie",
         "Listing des imageries médicales",
         "Supprimer une prescription imagérie",
         "Imprimer une prescription imagérie",
         "Partager une prescription imagérie",

         /** Gestion des e-prescriptions */
         "Créer une e-prescription",
         "Modifier une e-prescription",
         "Afficher une e-prescription",
         "Listing des e-prescriptions",
         "Supprimer une e-prescription",
         "Imprimer une e-prescription",
         "Partager une e-prescription",

          /** Accès au dossier médicale */
          "Rechercher un patient",
          "Voir le parcours de soins",
          "Listing des lignes de temps",
          "Ajouter une ligne de temps",
          "Supprimer une ligne de temps",
          "Ajouter/Modifier un médécin reférent",
          "Modifier le consentement éclairé",
          "Ajouter le consentement éclairé",

         /** Gestion des allergies */
         "Créer une allergie",
         "Modifier une allergie",
         "Afficher une allergie",
         "Listing des allergies",
         "Supprimer une allergie",

         /** Gestion des antécédents */
         "Créer un antécédent",
         "Modifier un antécédent",
         "Afficher un antécédent",
         "Listing des antécédents",
         "Supprimer un antécédent",

         /** Gestion des traitement actuels */
         "Créer un traitement actuel",
         "Modifier un traitement actuel",
         "Afficher un traitement actuel",
         "Listing des traitement actuels",
         "Supprimer un traitement actuel",

         /** Gestion des résultats de laboratoires */
         "Créer un résultat de laboratoire",
         "Modifier un résultat de laboratoire",
         "Afficher un résultat de laboratoire",
         "Listing des résultats de laboratoires",
         "Supprimer un résultat de laboratoire",

         /** Gestion des résultats d'imageries */
         "Créer un résultat d'imagerie",
         "Modifier un résultat d'imagerie",
         "Afficher un résultat d'imagerie",
         "Listing des résultats d'imageries",
         "Supprimer un résultat d'imagerie",

         /** Gestion des hospitalisations */
         "Créer une hospitalisation",
         "Modifier une hospitalisation",
         "Afficher une hospitalisation",
         "Listing des hospitalisations",
         "Supprimer une hospitalisation",

         /** Gestion des fichiers médico-externes */
         "Créer un fichier médico-externe",
         "Modifier un fichier médico-externe",
         "Afficher un fichier médico-externe",
         "Listing des fichiers médico-externess",
         "Supprimer un fichier médico-externe",

         /** Gestion des facturations */
         "Créer une facturation",
         "Modifier une facturation",
         "Afficher une facturation",
         "Listing des facturations",
         "Supprimer une facturation",

         /** Gestion des rendez-vous */
         "Créer un rendez-vous",
         "Modifier un rendez-vous",
         "Afficher un rendez-vous",
         "Listing des rendez-vous",
         "Supprimer un rendez-vous",

         /** Gestion des avis médicaux */
         "Créer un avis médicale",
         "Modifier un avis médicale",
         "Afficher un avis médicale",
         "Listing des avis médicaux",
         "Supprimer un avis médicale",

         /** Gestion des établissemnts */
         "Gestion administratives",
         "Gestion comptables",
         "Créer un établissemnt",
         "Modifier un établissemnt",
         "Afficher un établissemnt",
         "Listing des établissemnts",
         "Supprimer un établissemnt",

         /** Gestion des examens complémentaires */
         "Créer un examen complémentaire",
         "Modifier un examen complémentaire",
         "Afficher un examen complémentaire",
         "Listing des examens complémentaires",
         "Supprimer un examen complémentaire",

         /** Gestion des établissemnts prix */
         "Créer un établissement prix",
         "Modifier un établissement prix",
         "Afficher un établissement prix",
         "Listing des établissemnts prix",
         "Supprimer un établissement prix",

         /** Gestion des affiliations */
         "Créer une affiliation",
         "Modifier une affiliation",
         "Afficher une affiliation",
         "Listing des affiliations",
         "Supprimer une affiliation",
         "Mes affiliés",
         "Mes souscriptions",
         "voir les prospects",
         "voir les paiments affiliations",
         "voir les paiments prestations",

         /** Gestion des gestionnaires */
         "Créer un gestionnaire",
         "Modifier un gestionnaire",
         "Afficher un gestionnaire",
         "Listing des gestionnaires",
         "Supprimer un gestionnaire",

         /** Gestion des souscripteurs */
         "Créer un souscripteur",
         "Modifier un souscripteur",
         "Afficher un souscripteur",
         "Listing des souscripteurs",
         "Supprimer un souscripteur",

         /** Gestion des patients */
         "Créer un patient",
         "Modifier un patient",
         "Afficher un patient",
         "Listing des patients",
         "Supprimer un patient",

         /** Gestion des medécin contrôles */
         "Créer un medécin contrôle",
         "Modifier un medécin contrôle",
         "Afficher un medécin contrôle",
         "Listing des medécins contrôles",
         "Supprimer un medécin contrôle",

         /** Gestion des associations */
         "Créer une association",
         "Modifier une association",
         "Afficher une association",
         "Listing des associations",
         "Supprimer une association",

         /** Gestion des activités amas */
         "Créer une activité ama",
         "Modifier une activité ama",
         "Afficher une activité ama",
         "Listing des activités amas",
         "Supprimer une activité ama",

         /** Gestion des activités médecin reférent */
         "Créer une activité médecin reférent",
         "Modifier une activité médecin reférent",
         "Afficher une activité médecin reférent",
         "Listing des activités médecin reférent",
         "Supprimer une activité médecin reférent",

        ];


        foreach ($permissions as $permission) {
            $exist_permission = Permission::where('name', $permission)->first();
            if(!$exist_permission){
               Permission::create(['name' => $permission]);
            }
        }
    }
}
