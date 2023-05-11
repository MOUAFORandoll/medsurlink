<?php

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            ['id' => 1, 'nom_feature' => "ALERTES", 'guard_name' => "web"],
            ['id' => 2, 'nom_feature' => "TELECONSULTATIONS", 'guard_name' => "web"],
            ['id' => 3, 'nom_feature' => "GESTION DES ACTIVITES", 'guard_name' => "web"],
            ['id' => 4, 'nom_feature' => "AFFILIATIONS", 'guard_name' => "web"],
            ['id' => 5, 'nom_feature' => "AVIS MEDICAUX", 'guard_name' => "web"],
            ['id' => 6, 'nom_feature' => "CONSULTATION MEDECINE GENERALES", 'guard_name' => "web"],
            ['id' => 7, 'nom_feature' => "CONSULTATION CARDIOLOGIQUES", 'guard_name' => "web"],
            ['id' => 8, 'nom_feature' => "RENDEZ-VOUS", 'guard_name' => "web"],
            ['id' => 9, 'nom_feature' => "DOSSIER MEDICAL", 'guard_name' => "web"],
            ['id' => 10, 'nom_feature' => "E-PRESCRIPTIONS", 'guard_name' => "web"],
            ['id' => 11, 'nom_feature' => "BULLETIN D'EXAMEN", 'guard_name' => "web"],
            ['id' => 12, 'nom_feature' => "PRESCRIPTION IMAGERIE", 'guard_name' => "web"],
            ['id' => 13, 'nom_feature' => "RESULTAT DE LABORATOIRE", 'guard_name' => "web"],
            ['id' => 14, 'nom_feature' => "RESULTAT D'IMAGERIE", 'guard_name' => "web"],
            ['id' => 15, 'nom_feature' => "NOTIFICATIONS", 'guard_name' => "web"],
            ['id' => 16, 'nom_feature' => "BON DE PRISE EN CHARGE", 'guard_name' => "web"],
            ['id' => 17, 'nom_feature' => "IMAGERIES MEDICALES", 'guard_name' => "web"],
            ['id' => 18, 'nom_feature' => "ROLES ET PERMISSIONS", 'guard_name' => "web"],
            ['id' => 19, 'nom_feature' => "FACTURATIONS", 'guard_name' => "web"],
            ['id' => 20, 'nom_feature' => "GESTION DES PATIENTS", 'guard_name' => "web"],
            ['id' => 21, 'nom_feature' => "PARCOURS DE SOINS", 'guard_name' => "web"],
            ['id' => 22, 'nom_feature' => "DELAIS DE PRISE EN CHARGES", 'guard_name' => "web"],
            ['id' => 23, 'nom_feature' => "METRIQUES", 'guard_name' => "web"],
            ['id' => 24, 'nom_feature' => "ALLERGIES", 'guard_name' => "web"],
            ['id' => 25, 'nom_feature' => "HOSPITALISATIONS", 'guard_name' => "web"],
            ['id' => 26, 'nom_feature' => "ANTECEDENTS", 'guard_name' => "web"],
            ['id' => 27, 'nom_feature' => "FICHIER MEDICO-EXTERNES", 'guard_name' => "web"],
            ['id' => 28, 'nom_feature' => "TRAITEMENTS ACTUELS", 'guard_name' => "web"],
            ['id' => 29, 'nom_feature' => "COMPTE RENDU OPERATOIRE", 'guard_name' => "web"],
            ['id' => 30, 'nom_feature' => "SOUSCRIPTEURS", 'guard_name' => "web"],
            ['id' => 31, 'nom_feature' => "PATIENTS", 'guard_name' => "web"],
            ['id' => 32, 'nom_feature' => "MEDECINS CONTRÔLES", 'guard_name' => "web"],
            ['id' => 33, 'nom_feature' => "ASSISTANTES", 'guard_name' => "web"],
            ['id' => 34, 'nom_feature' => "PRATICIENS", 'guard_name' => "web"],
            ['id' => 35, 'nom_feature' => "PARTENAIRES", 'guard_name' => "web"],
            ['id' => 36, 'nom_feature' => "COMPTABLES", 'guard_name' => "web"],
            ['id' => 37, 'nom_feature' => "ETABLISSEMENTS", 'guard_name' => "web"],
            ['id' => 38, 'nom_feature' => "ASSOCIATIONS", 'guard_name' => "web"],
            ['id' => 39, 'nom_feature' => "GESTIONNAIRES", 'guard_name' => "web"],
            ['id' => 40, 'nom_feature' => "RÔLES ET PERMISSIONS", 'guard_name' => "web"],
            ['id' => 41, 'nom_feature' => "PROFILS UTILISATEURS", 'guard_name' => "web"],
            ['id' => 42, 'nom_feature' => "EXAMENS COMPLEMENTAIRES", 'guard_name' => "web"],
            ['id' => 43, 'nom_feature' => "LIGNE DE TEMPS", 'guard_name' => "web"],
            ['id' => 44, 'nom_feature' => "CONSENTEMENT ECLAIRE", 'guard_name' => "web"],
            ['id' => 45, 'nom_feature' => "RECOMMANDATIONS", 'guard_name' => "web"],
            ['id' => 46, 'nom_feature' => "FORMATIONS", 'guard_name' => "web"],
            ['id' => 47, 'nom_feature' => "AUTRES", 'guard_name' => "web"],
            ['id' => 48, 'nom_feature' => "PAiEMENT", 'guard_name' => "web"],
        ];
        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
