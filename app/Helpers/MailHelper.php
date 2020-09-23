<?php


if(!function_exists('informedPatientOfRapport'))
{

    /**
     * Envoi un mail pour informer un patient de la mise à jour de son rapport
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    function informedPatientOfRapport($user) {
        if (!is_null($user->email) && $user->email != 'null'){
            try{
                $mail = new \App\Mail\InformedPatientOfRapport($user);
                \Illuminate\Support\Facades\Mail::to($user->email)->send($mail);
            } catch (\Swift_TransportException $transportException){
                $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                return response()->json(['patient'=>$user, "message"=>$message]);
            }
        }
    }
}

if(!function_exists('informedSouscripteurOfRapport'))
{

    /**
     * Envoi un mail pour informer un souscripteur de la mise à jour du rapport de l'un de ses affiliés
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    function informedSouscripteurOfRapport($souscripteur,$patient) {
        if (!is_null($souscripteur->user->email) && $souscripteur->user->email != 'null'){
            try {
                $mail = new \App\Mail\InformedSouscripteurOfRapport($souscripteur,$patient);
                \Illuminate\Support\Facades\Mail::to($souscripteur->user->email)->send($mail);
            } catch (\Swift_TransportException $transportException){
                $message = "L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur";
                return response()->json(['patient'=>$souscripteur->user, "message"=>$message]);
            }

        }
    }
}
if(!function_exists('informedPatientAndSouscripteurs'))
{

    /**
     * Envoi un mail aux souscripteurs et au patient
     * @param $patient
     */
    function informedPatientAndSouscripteurs($patient,$transmit=0) {
        $send  = false;
        if (($patient->user->isMedicasure == '0' || $patient->user->isMedicasure == 0) && $transmit == 0){
            $send = true;
        }
        if (($patient->user->isMedicasure == '1' || $patient->user->isMedicasure == 1) && $transmit == 1){
            $send = true;
        }

        if ($transmit == 3)
            $send = true;

        if ($send == true){
            $user = $patient->user;
            informedPatientOfRapport($user);
            $precedentSouscripteur = $patient->souscripteur;

            foreach ($patient->financeurs as $financeur){
                if (!is_null($financeur->financable->user)){
                    informedSouscripteurOfRapport($financeur->financable,$patient);
                }
            }
            if (!is_null($precedentSouscripteur)){
                informedSouscripteurOfRapport($precedentSouscripteur,$patient);
            }
        }
    }
}
