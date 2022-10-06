<?php

use App\Models\ActivitesAma;
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
        $automatiques = [
            'Attribution d’un médecin référent à l’affilié',
            'Changement de Médecin référent selon Procédure adéquate',
            'Encodage des RDV du Patient selon Procédure adéquate',
            'Gestion de l’alerte médicale selon Procédure adéquate',
            'Transmission éventuelle d’un lien du Dossier médical en externe',
        ];
        $manuelles = [
'Réception d’une alerte médicale venant de l’affilié',
'Planification de rendez-vous chez un prestataire de soins selon Procédure adéquate',
'Résolution difficulté administrative d’un souscripteur',
'Résolution difficulté administrative d’un affilié',
'Aide au renouvellement d’une affiliation selon Procédure adéquate',
'Suivi réalisation des rendez-vous',
'Transmission de factures au souscripteur',
'Sélection d’un cas en fonction de la 1ère Catégorisation sur l’échelle du formulaire 1/5',
'Explication du service Medicasure au souscripteur',
'Explication du service Medicasure à l’affilié',
'Suivi réalisation des rendez-vous chez les prestataires',
'Réception et traitement des factures des prestataires de 1ère Ligne',
'Transmission des factures au souscripteur',
'Rappel du patient pour évaluer sa satisfaction à J2 au plus tard',
'Rappel du souscripteur pour évaluer sa satisfaction à J7 au plus tard (Accès aux dossiers – Satisfaction service chez Prestataire / tarification – recommandation)',
"obtention du dossier physique du patient pour encodage ( compte rendu, CD)",
"organisation de l\'obtention des médicaments du patient",
"organisation discussion pluridisciplinaire",
"organisation d'une prestation à domicile ",
"encodage données medicales",
"reception d'une allerte par le souscripteur",
"reception d'une alerte par la personne de contact",
"Appel du souscripteur après l'affiliation",
"Appel du patient après l'affiliation",
"obtention du dossier physique du patient pour encodage ( compte rendu, CD)",
"organisation de l\'obtention des médicaments du patient",
"organisation discussion pluridisciplinaire",
"organisation d'une prestation à domicile ",
"encodage données medicales",
"reception d'une allerte par le souscripteur",
"reception d'une alerte par la personne de contact"

        ];
        foreach ($automatiques as $automatique){
            $exist_activity = ActivitesAma::where('description_fr', $automatique)->first();
            if(!$exist_activity){
                ActivitesAma::create(['description_fr'=>$automatique, 'description_en'=>$automatique, 'type'=> 'AUTOMATIQUE']);
            }  
        }

        foreach ($manuelles as $manuelle){
            $exist_activity = ActivitesAma::where('description_fr', $manuelle)->first();
            if(!$exist_activity){
                ActivitesAma::create(['description_fr'=>$manuelle, 'description_en'=>$manuelle, 'type'=> 'MANUELLE']);
            } 
        }
    }
}
