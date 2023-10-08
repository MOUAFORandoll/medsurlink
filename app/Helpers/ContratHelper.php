<?php

use GuzzleHttp\Client;

if (!function_exists('genererContrat')) {
    function genererContrat($contrat)
    {
        $client = new Client();
        $env = strtolower(config('app.env'));
        if ($env === 'local')
            $url = 'http://localhost:8000/api/v1.0.1/medsurlink-contrat';
        else if ($env === 'staging')
            $url = 'https://www.staging.medicasure.com/api/v1.0.1/medsurlink-contrat';
        else
            $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.1/medsurlink-contrat';

        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => $contrat
        ]);
    }
}
if (!function_exists('getContrat')) {
    function getContrat($patient)
    {
        $client = new Client();
        $env = strtolower(config('app.env'));
        if ($env === 'local')
            $url = 'http://localhost:8000/api/v1.0.0/get-contrat-by-name';
        else if ($env === 'staging')
            $url = 'https://www.staging.medicasure.com/api/v1.0.0/get-contrat-by-name';
        else
            $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.0/get-contrat-by-name';

        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => ["nom" => $patient->nom, 'prenom' => $patient->prenom]
        ]);
        $contrat = $res->getBody()->getContents();
        return json_decode($contrat);
    }
}

if (!function_exists('countContrats')) {
    function countContrats()
    {
        $client = new Client();
        $env = strtolower(config('app.env'));
        if ($env === 'local')
            $url = 'http://localhost:8000/api/v1.0.0/count-contrats';
        else if ($env === 'staging')
            $url = 'https://www.staging.medicasure.com/api/v1.0.0/count-contrats';
        else
            $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.0/count-contrats';

        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $countContrats = $res->getBody()->getContents();
        return json_decode($countContrats);
    }
}
