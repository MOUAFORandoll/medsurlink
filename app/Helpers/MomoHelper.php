<?php

use GuzzleHttp\Client;

if(!function_exists('getToken'))
{
    /**
     * Fonction permettant d'obtenir un token pour effectuer un paiement
     * @param $subscriptionKey
     * @param $base64
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    function getToken($subscriptionKey, $base64){
        $base_uri = 'https://proxy.momoapi.mtn.com/collection/token/';
//        $base_uri = 'https://sandbox.momodeveloper.mtn.com/collection/token/';
        $headers = [
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            'Authorization' => 'Basic '.$base64,
        ];

        try {
            $client = new Client(['base_uri' => $base_uri]);
            $request = new \GuzzleHttp\Psr7\Request('POST',$base_uri,$headers);
            $response = $client->send($request);
            $responseArray = json_decode($response->getBody()->getContents(),true);
            return $responseArray['access_token'];

        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }
    }
}
if(!function_exists('getKey'))
{
    /**
     * Fonction permettant en environnement sandbox d'obtenir une clé api
     * @param $subscriptionKey
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    function getKey($subscriptionKey, $uuid){
        $base_uri = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/".$uuid."/apikey";
        $headers = [
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
        ];

        try {
            $client = new Client(['base_uri' => $base_uri]);
            $request = new \GuzzleHttp\Psr7\Request('POST',$base_uri,$headers);
            $response = $client->send($request);
            $responseArray = json_decode($response->getBody()->getContents(),true);
            return $responseArray['apiKey'];

        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }
    }
}

if(!function_exists('createUser'))
{
    /**
     * Fonction permettant d'enregistrer un utilisateur pour effectuer les différentes transactions
     * @param $subscriptionKey
     * @param $uuid
     * @param $host
     * @return \Illuminate\Http\JsonResponse
     */
    function createUser($subscriptionKey, $uuid, $host){
        $base_uri = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser";
        $headers = [
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            'X-Reference-Id' => $uuid,
            'Host'=>$host
        ];
        $operation = array('providerCallbackHost'=>'Medicasure');
        $body= json_encode($operation) ;
        try {
            $client = new Client(['base_uri' => $base_uri]);
            $request = new \GuzzleHttp\Psr7\Request('POST',$base_uri,$headers,$body);
            $response = $client->send($request);
        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }
    }
}

if(!function_exists('requestToPay'))
{
    /**
     * Fonction permettant d'effectuer le paiement
     * @param $referenceId
     * @param string $environment
     * @param $subscriptionKey
     * @param $accessToken
     * @param $operation
     * @param $host
     * @return array
     */
    function requestToPay($referenceId, $environment='mtncameroon', $subscriptionKey, $accessToken, $operation, $host=null,$callbackUrl){
        $curl = curl_init();
//        CURLOPT_URL => "https://ericssonbasicapi1.azure-api.net/collection/v1_0/requesttopay",

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://proxy.momoapi.mtn.com/collection/v1_0/requesttopay",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$operation,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "X-Reference-Id: $referenceId",
                "X-Target-Environment: mtncameroon",
                "Ocp-Apim-Subscription-Key: $subscriptionKey",
                "Content-Type: application/json",
                "X-Callback-Url: $callbackUrl",
                ": "
            ),
        ));

        $response = curl_exec($curl);

        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return compact('response','responseCode');
    }
}

if(!function_exists('requestToPayStatus'))
{
    /**
     * Fonction permettant d'obtenir le statut d'un paiement
     * @param $referenceId
     * @param string $environment
     * @param $subscriptionKey
     * @param $accessToken
     * @return \Illuminate\Http\JsonResponse|\Psr\Http\Message\ResponseInterface
     */
    function requestToPayStatus($referenceId, $environment='mtncameroon', $subscriptionKey, $accessToken,$callbackUrl){
        $base_uri = 'https://proxy.momoapi.mtn.com/collection/v1_0/requesttopay/'.$referenceId;
//        $base_uri = 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/'.$referenceId;
        $headers = [
            'X-Target-Environment' => $environment,
            'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            'Authorization' => 'Bearer '.$accessToken,
            "Content-Type: application/json",
            "X-Callback-Url: ".$callbackUrl,
        ];

        try {
            $client = new Client(['base_uri' => $base_uri]);
            $request = new \GuzzleHttp\Psr7\Request('GET',$base_uri,$headers);
            $response = $client->send($request);
            return $response;

        }catch (Exception $exception){
            return response()->json(['erreur'=>$exception->getMessage()],419);
        }
    }
}
