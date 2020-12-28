<?php

use Illuminate\Database\Seeder;

class GroupeActiviteMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gam = [
            array('groupe'=>'1','descriptions'=>
                array(
                    '1ère Catégorisation des Cas ',
                    'Télé – (Hétéro) - consultation OBLIGATOIRE  ',
                    'Création du Dossier – Patient et Encodage de la Téléconsultation dans Medsurlink',
                    'Présentation Systématique de la Vignette clinique du Cas dans le groupe « Suivi-Affilié » sur Slack ',
                    'PEC du Cas selon Algorithme - Cas « Très Urgent : <12h> » : i- Contact avec Souscripteur ; ii- Gestion Optimale médicale, logistique, financière de bout en bout ; iii- Mise à jour du rapport dans Medsurlink ',
                    'PEC du Cas selon Algorithme - Cas « Urgent : <48h> : Possibilité de Valider i-Prise de sang de Base (CRP-NFS-Fct° Rénale-Iono Simple) ; ii- Soins d’urgence (Pansement – Volumisation – Antalgique – Antibiothérapie 2 Jours – Conseil & « Rassurance) ; iii- Mise à jour rapport Medsurlink ; iv- Re-contact avec le patient à J3',
                    'PEC du Cas selon Algorithme : Cas « Normal > 48h » : Gestion de la plainte à distance de bout en bout i- Ordonnance à Distance ; ii-  Contact mail avec souscripteur pour validation PEC (NB : mettre en Cc medical@medicasure.com ) ; iii- Mise à jour Rapport sur Medsurlink ; iv- RDV pour Suivi de l’évolution (PAS DE BILAN) <1 – 3> semaine-s ',
                    'Encodage des RDV du Patient',
                    'Contrôle des rapports médicaux des Médecins 1ère ligne et Validation (Archivage)',
                    'Contrôle des factures générées par les Partenaires et Validation '
                )),
            array('groupe'=>'2','descriptions'=>
                array(
                    'Consultation à domicile ou en Cabinet/Clinique',
                    'Consultation générale de Prévention (Primaire – secondaire – tertiaire – quaternaire)',
                    'Explication de la maladie à l’affilié ou au souscripteur',
                    'Consentement éclaire familiale pour Projet de soins Fin de Vie – Palliatif'
                )),
            array('groupe'=>'3','descriptions'=>
                array(
                    'Représentation auprès des partenaires acquis ou à acquérir en temps de besoin',
                    'Contrôle-qualité intermittent au sein des locaux des partenaires du réseau Medicasure',
                    'Formation des prestataires à l’outil de gestion médicale Medsurlink aux prestataires',
                    'Présentation de l’outil de gestion médicale Medsurlink aux prestataires'
                )),
            array('groupe'=>'4','descriptions'=>
                array(
                    'Rédaction des articles pour l’éducation de la population',
                    'Traduction des articles et textes, et/ou vérification des traductions déjà faites',
                    'Rédaction des protocoles et process de prise en charge des patients ',
                )),
        ];

        foreach ($gam as $item){
            $groupe_id = $item['groupe'];
            $descriptions = $item['descriptions'];
            foreach ($descriptions as $description){
                \App\Models\GroupeActiviteMission::create(['groupe_id'=>$groupe_id,'description'=>$description]);
            }
        }
    }
}
