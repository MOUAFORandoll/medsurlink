<?php

namespace App\Traits;

use App\Notifications\SendSMS;
use App\SMS;

trait SmsTrait
{
    /**
     * This function is a shortcut to send rapidly a SMS to someone
     *
     * @param $telephone
     * @param $message
     * @param null $sender
     */
    public function sendSMS($telephone, $message, $sender = null)
    {
        sendSMS($telephone, $message, $sender);
    }

    /**
     * Send a SMS to a User
     *
     * @param $user
     * @param null $sender
     */
    function sendSmsToUser($user, $sender = null) {
        if (!is_null($user)){
            try {
//                $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
                $nom = substr(strtoupper( $user->nom),0,12);
                sendSMS($user->telephone,trans('sms.accountUpdated',['nom'=>$nom],'fr'),$sender);
            }catch (\Exception $exception){
                //$exception
            }
        }
    }


}
