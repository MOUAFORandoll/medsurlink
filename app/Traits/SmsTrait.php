<?php

namespace App\Traits;

use App\Notifications\SendSMS;
use App\SMS;
use Log;

trait SmsTrait
{
    /**
     * This function is a shortcut to send rapidly a SMS to someone
     *
     * @param $telephone
     * @param $message
     * @param null $sender
     */
    public function sendSMS($telephone, $message, $sender = "MEDSURLINK")
    {
        sendSMS($telephone, $message, $sender);
    }
    
    /**
     * Send a SMS to a User
     *
     * @param $user
     * @param null $sender
     */
    function sendSmsToUser($user, $sender = "MEDSURLINK") {
        if (!is_null($user)){
            try {
//                $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
                $nom = substr(strtoupper( $user->name),0,9);
                sendSMS($user->telephone,trans('sms.accountUpdated',['nom'=>$nom],'fr'),$sender);
            }catch (\Exception $exception){
                //$exception
            }
        }
    }

    /**
     * Rappeler des rendez vous à des patients
     *
     * @param $user
     * @param null $sender
     */
    function RappelerRdvViaSMSTo($user, $praticien, $date, $heure, $sender = "MEDSURLINK") {
        if (!is_null($user)){
            try {
                $nom = strtoupper($user->nom);
                $praticienPhone = $praticien->telephone;
                Log::alert($praticienPhone);
                $praticien = strtoupper($praticien->name);
                sendSMS($user->telephone,trans('sms.rappelerRendezVous',['nom'=>$nom,'date'=>$date,'heure'=>$heure,'praticien'=>$praticien],'fr'),$sender);
                sendSMS($praticienPhone,trans('sms.rappelerRendezVousPraticien',['nom'=>$nom,'date'=>$date,'heure'=>$heure,'praticien'=>$praticien],'fr'),$sender);

             }catch (\Exception $exception){
                //$exception
            }
        }
    }

    /**
     * Rappeler des rendez vous à des patients
     *
     * @param $user
     * @param null $sender
     */
    function RappelRdvViaSMSTo($patient_name, $patient_phone, $medecin_name, $medecin_phone, $date, $heure, $sender = "MEDSURLINK") {
        try {
            sendSMS($patient_phone, trans('sms.rappelerRendezVous',['nom' => $patient_name, 'date' => $date, 'heure' => $heure, 'praticien' => $medecin_name], 'fr'), $sender);
            sendSMS($medecin_phone, trans('sms.rappelerRendezVousPraticien',['nom' => $patient_name, 'date' => $date, 'heure' => $heure, 'praticien' => $medecin_name], 'fr'), $sender);

         }catch (\Exception $exception){
            //$exception
        }
    }

}
