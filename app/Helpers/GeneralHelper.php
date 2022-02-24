<?php

use App\Mail\Facture\AchatOffre;
use App\SMS;
use App\Notifications\SendSMS;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

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

if(!function_exists('sendSmsToUser'))
{
    /**
     * Send a SMS to a User
     *
     * @param $user
     * @param null $sender
     */
    function sendSmsToUser($user,$sender = null) {
        if (!is_null($user)){
            if ($user->decede == 'non'){
                try {
                    $nom = (is_null($user->prenom) ? "" : ucfirst($user->prenom) ." ") . "". strtoupper( $user->nom);
                    sendSMS($user->telephone,trans('sms.accountUpdated',['nom'=>$nom],'fr'),$sender);
                }catch (\Exception $exception){
                    //$exception
                }
            }
        }
    }
}
if(!function_exists('_group_by'))
{
    /**
     * Group array by key
     *
     * @param $array
     * @param $key
     */
    function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}
if(!function_exists('isJSON'))
{
    function isJSON($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
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

if(!function_exists('mapExpectValue'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function mapExpectValue($arrayList,$unNeedArray)
    {
      return Arr::except($arrayList,$unNeedArray);
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
        else if(substr($response, 0, 2) == '32') {
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




    if(!function_exists('EnvoieDeFactureApresSouscription'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function EnvoieDeFactureApresSouscription($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $beneficiaire);
            Mail::to($email_souscripteur)->send(new AchatOffre($pdf['output'], $nom_souscripteur, $description));
        }catch (\Exception $exception){
            //$exception
        }
    }
}

if(!function_exists('generationPdfFactureOffre'))
{
    /**
     * @param $string_with_accent
     * @return string
     */
    function generationPdfFactureOffre($commande_id, $commande_date, $montant_total, $echeance, $description, $quantite, $prix_unitaire, $nom_souscripteur, $email_souscripteur, $rue, $adresse, $ville, $beneficiaire)
    {
        //return view('impression_offre');
        try {
            $pdf = PDF::loadView('impression_offre', ['commande_id' => $commande_id, 'commande_date' => $commande_date, 'montant_total' => number_format($montant_total, 2, ',', ' '), 'echeance' => $echeance, 'description' => mb_strtoupper($description), 'quantite' => $quantite, 'prix_unitaire' => number_format($prix_unitaire, 2, ',', ' '), 'nom_souscripteur' => $nom_souscripteur, 'email_souscripteur' => $email_souscripteur, 'rue' => $rue, 'adresse' => $adresse, 'ville' => $ville, 'beneficiaire' => $beneficiaire]);
            return ['output' => $pdf->output(), 'stream' => $pdf->stream($description.".pdf")];
        }catch (\Exception $exception){
            //$exception
        }
    }
}
