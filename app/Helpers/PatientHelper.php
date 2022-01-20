<?php

use App\Http\Controllers\Api\UserController;
use App\Models\DossierMedical;
use App\Models\Suivi;
use Carbon\Carbon;

if(!function_exists('genererDossierMedical')) {
    function genererDossierMedical($patient_id)
    {
        $numero_dossier = randomNumeroDossier();
        $dossier = DossierMedical::create([
            'patient_id'=>$patient_id,
            "date_de_creation"=>Carbon::now()->format('Y-m-d'),
            "numero_dossier"=>$numero_dossier,
        ]);

        return $dossier;
    }
}

if(!function_exists('ajouterPatientAuSuivi')) {
    function ajouterPatientAuSuivi($dossier_id,$categorie_id)
    {
        $suivi = Suivi::create([
            'dossier_medical_id'=>$dossier_id,
            'motifs'=>'Prise en charge initiale en attente',
            'categorie_id'=>$categorie_id
        ]);

        return $suivi;
    }
}

if(!function_exists('randomNumeroDossier')) {
    function randomNumeroDossier()
    {
        $resultat = ''.rand(0,99999999);
        while (strlen($resultat)<8){
            $longueur = strlen($resultat);
            if ($longueur == 1)
                $resultat = $resultat.''.rand(0,9999999);
            elseif ($longueur == 2 )
                $resultat = $resultat.''.rand(0,999999);
            elseif ($longueur == 3 )
                $resultat = $resultat.''.rand(0,99999);
            elseif ($longueur == 4 )
                $resultat = $resultat.''.rand(0,9999);
            elseif ($longueur == 5 )
                $resultat = $resultat.''.rand(0,999);
            elseif ($longueur == 6 )
                $resultat = $resultat.''.rand(0,99);
            elseif ($longueur == 7 )
                $resultat = $resultat.''.rand(0,9);

        }

        while(count(DossierMedical::where('numero_dossier','=',$resultat)->get())>0){
            $resultat = randomNumeroDossier();
        }

        return $resultat;
    }
}
