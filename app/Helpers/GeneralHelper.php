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
        // To not to trigger an error while sending the message, check if the telephone is well formatted

        $response = formatTelephone($telephone);

        if(!is_null($response)) {
            $sms = new SMS();
            $sms->telephone = $response;
            $sms->notify(new SendSMS($message, getFullNameWithoutAccent( is_null($sender) ? 'MEDSURLINK' : $sender)));
        }

        // TODO: Perform otherwise action
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

        // convert the string to an array
        $arr = str_split($telephone);


        // Remove everything except numbers
        $newArr = array_filter($arr, function ($item) {
            return preg_match("/[0-9]/i", $item);
        });

        // Parse to string
        $response = join($newArr);

        // remove the international calling prefix
        if(substr($response, 0, 2) == '00') {
            $response = substr($response, 2, strlen($response));
        }
        else if(substr($response, 0, 3) == '011') {
            $response = substr($response, 3, strlen($response));
        }

        // remove the country code
        // Cameroon
        if(substr($response, 0, 3) == '237') {
            $response = substr($response, 3, strlen($response));
        }

        // Belgium
        else if(substr($response, 0, 32) == '32') {
            $response = substr($response, 2, strlen($response));
        }


        // Cameroon pattern 6x xx xx xx xx
        if(strlen($response) == 8) {
            return '2376' . $response;
        }

        // Cameroon pattern 6x xx xx xx xx
        else if(strlen($response) == 9 && $response[0] == '6') {
            return '237' . $response;
        }

        // belgium pattern xx xx xx xx xx
        else if(strlen($response) == 10 || strlen($response) == 9) {
            return '32' . $response;
        }

        // Incorrect number
        return null;
    }
}

