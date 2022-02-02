<?php
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

if(!function_exists('getOmToken')){
    /**
     * Fonction permettant d'obtenir un token pour effectuer un paiement
     */
    function getOmToken(){
//        $base_uri = 'https://apiw.orange.cm/token';
        $base_uri = 'https://api-s1.orange.cm/token';
        $headers = [
            "Authorization"=> "Basic ".base64_encode('iDNk1JG_n9jS9M9Bfjs9KftyAzEa:9LMVsilVX13KnBgdssAxA9VyRl4a'),
            "Content-Type"=>"application/x-www-form-urlencoded"
        ];
        $body = ['grant_type'=>'client_credentials'];
        try {
            $client = new Client(['base_uri' => $base_uri, 'verify' => false]);
            $response = $client->request('POST',$base_uri,['headers'=>$headers,'form_params'=>$body]);
            $responseArray = json_decode($response->getBody()->getContents(),true);
            return $responseArray['access_token'];

        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }
    }
}

if(!function_exists('initierPaiement')) {
    /**
     * Fonction permettant d'initier un paiement
     */
    function initierPaiement($acces_token)
    {
//        $base_uri = 'https://apiw.orange.cm/omcoreapis/1.0.2/mp/init';
        $base_uri = 'https://api-s1.orange.cm/omcoreapis/1.0.2/mp/init';
        $headers = [
            "X-AUTH-TOKEN" => "TUVEU1VSUFJPRDpNRURTVVJQUk9EMjAyMA==",
            "Authorization" => "Bearer ".$acces_token
        ];
        try {
            $client = new Client(['base_uri' => $base_uri, 'verify' => false]);
            $response = $client->request('POST', $base_uri, ['headers'=>$headers]);
            $responseArray = json_decode($response->getBody()->getContents(), true);
            return $responseArray['data']['payToken'];

        } catch (Exception $exception) {
            return response()->json(['erreur' => $exception->getMessage()], 419);
        }
    }
}

if(!function_exists('procederAuPaiement')) {
    /**
     * Fonction permettant de demander à un user de payer
     */
    function procederAuPaiementOm($acces_token, $body)
    {
//        $base_uri = 'https://apiw.orange.cm/omcoreapis/1.0.2/mp/pay';
        $base_uri = 'https://api-s1.orange.cm/omcoreapis/1.0.2/mp/pay';
        $headers = [
            "X-AUTH-TOKEN" => "TUVEU1VSUFJPRDpNRURTVVJQUk9EMjAyMA==",
            "Authorization" => "Bearer ".$acces_token,
            "Content-Type" => "application/json"
        ];


        try {
            $client = new Client(['base_uri' => $base_uri, 'verify' => false]);
            $response = $client->request('POST', $base_uri, ['headers'=>$headers,'json'=> $body]);

            $responseArray = json_decode($response->getBody()->getContents(), true);

            return $responseArray;

        } catch (Exception $exception) {
            return response()->json(['erreur' => $exception->getMessage()], 419);
        }
    }
}

if(!function_exists('statutPaiementOm')) {
    /**
     * Fonction permettant de verifier le statut de paiement
     */
    function statutPaiementOm($acces_token,$pay_token)
    {
//        $base_uri = 'https://apiw.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/'.$pay_token;
        $base_uri = 'https://api-s1.orange.cm/omcoreapis/1.0.2/mp/paymentstatus/'.$pay_token;
        $headers = [
            "X-AUTH-TOKEN" => "TUVEU1VSUFJPRDpNRURTVVJQUk9EMjAyMA==",
            "Authorization" => "Bearer ".$acces_token,
            "Content-Type" => "application/json"
        ];


        try {
            $client = new Client(['base_uri' => $base_uri, 'verify' => false]);
            $response = $client->request('GET', $base_uri, ['headers'=>$headers]);

            $responseArray = json_decode($response->getBody()->getContents(), true);
            return $responseArray;

        } catch (Exception $exception) {
            return response()->json(['erreur' => $exception->getMessage()], 419);
        }
    }
}
