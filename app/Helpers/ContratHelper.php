<?php

use GuzzleHttp\Client;

if(!function_exists('genererContrat'))
{
    function genererContrat($contrat) {
        $client = new Client();
        $url = 'http://localhost:8001/api/v1.0.1/medsurlink-contrat';
        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json'=>$contrat
        ]);
    }
}
