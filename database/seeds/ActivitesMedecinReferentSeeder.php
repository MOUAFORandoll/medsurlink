<?php

use Illuminate\Database\Seeder;

class ActivitesMedecinReferentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $automatiques = [
            'Télé – (Hétéro) – consultation',
            'Encodage de la Téléconsultation dans Medsurlink',
            '2ème Catégorisation du cas PEC du Cas selon Algorithme « Très urgent » = 5/5',
            '2ème Catégorisation du cas PEC du Cas selon Algorithme « Urgent » = 3-4/5',
            '2ème Catégorisation du cas PEC du Cas selon Algorithme « Normal » = 1-2/5',
            'Mise à jour du rapport dans Medsurlink',
            'Encodage des RDV du Patient',
            'Contrôle des rapports médicaux des Médecins 1ère ligne et Validation (Archivage)',
            'Discussion avec affilié / souscripteur sur RDV planifié',
            'Télé-hétéro-consultation supplémentaire pour affilié',
        ];
        $manuelles = [
            'Présentation Systématique de la Vignette clinique du Cas au 3ème Ligne',
            'Communication d’une CAT médicale et logistique',
            'Consultation à domicile ou en Cabinet/Clinique',
            'Consultation générale préventive',
            'Etablissement d’un plan de Prévention (Primaire – secondaire – tertiaire – quaternaire)',
            'Explication téléphonique de la maladie à l’affilié et/ou au souscripteur',
            'Consentement éclairé familial pour Projet de soins Fin de Vie – Palliatif',
            'Participation à une discussion multidisciplinaire pour un Cas',
            'Etablissement d’un Bon de prise en charge / Ordonnance en externe pour un affilié',
            'Réponse téléphonique à un appel de 1ère ligne pour un affilié',
            'Discussion avec affilié / souscripteur sur RDV planifié',
            'Revue systématique du dossier d’un affilié',
        ];
        foreach ($automatiques as $automatique){
            \App\Models\ActivitesMedecinReferent::create([
               'description_fr'=>$automatique,
               'description_en'=>$automatique,
               'type'=> 'AUTOMATIQUE',
            ]);
        }

        foreach ($manuelles as $manuelle){
            \App\Models\ActivitesMedecinReferent::create([
               'description_fr'=>$manuelle,
               'description_en'=>$manuelle,
               'type'=> 'MANUELLE',
            ]);
        }
    }

}
