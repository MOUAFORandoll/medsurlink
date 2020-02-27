<?php

use App\SMS;
use App\Notifications\SendSMS;

if(!function_exists('sendSMS'))
{
    /**
     * Send a SMS to a number
     *
     * @param $telephone
     * @param $message
     * @param $sender
     */
    function sendSMS($telephone, $message, $sender = null) {
        $sms = new SMS();
        $sms->telephone = $telephone;
        $sms->notify(new SendSMS($message, getFullNameWithoutAccent( is_null($sender) ? 'Medicasure' : $sender)));
    }
}


if(!function_exists('getFullNameWithoutAccent'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function getFullNameWithoutAccent($string_with_accent)
    {
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        //Préférez str_replace à strtr car strtr travaille directement sur les octets, ce qui pose problème en UTF-8
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');

        $string_without_accent = str_replace($search, $replace, $string_with_accent);
        return $string_without_accent;
    }
}

if(!function_exists('formatTelephone'))
{
    function formatTelephone($telephone) {
        return $telephone;
    }
}

