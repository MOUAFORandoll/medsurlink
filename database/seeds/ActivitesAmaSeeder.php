<?php

use Illuminate\Database\Seeder;

class ActivitesAmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activites = [
            'Explication du service Medicasure au souscripteur',
            'Explication du service Medicasure à l’affilié',
            'Vérification existence d’un Profil Affilié et Souscripteur conforme sur Medsurlink',
            'Attribution d’un médecin référent à l’affilié',
            'Changement de Médecin référent selon Procédure adéquate',
            'Vérification de l’existence de l’affilié dans « Suivi des Patients » - « PEC »',
            'Vérification de l’existence d’un rendez-vous dont le motif est « 2ème Consultation Médecine générale préventive
            planifié 6 mois plus tard »',
            'Rappel du patient pour évaluer sa satisfaction à J2 au plus tard',
            'Rappel du souscripteur pour évaluer sa satisfaction à J7 au plus tard',
            'Réception d’une alerte médicale venant de l’affilié',
            'Gestion de l’alerte médicale selon Procédure adéquate',
            'Planification de rendez-vous chez un prestataire de soins selon Procédure adéquate',
            'Résolution difficulté administrative d’un souscripteur',
            'Résolution difficulté administrative d’un affilié',
            'Aide au renouvellement d’une affiliation selon Procédure adéquate',
            'Suivi réalisation des rendez-vous',
            'Validation médicale après discussion avec médecin référent',
            'Validation financière après contrôle solvabilité souscripteur',
            'Transmission de factures au souscripteur',
            'Transmission exceptionnelle d’un lien du Dossier médical en externe'
        ];
        foreach ($activites as $activite){
            \App\Models\ActivitesAma::create([
               'description_fr'=>$activite,
               'description_en'=>$activite
            ]);
        }
    }
}
