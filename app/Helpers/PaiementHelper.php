<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client;

if (!function_exists('paiementMomo')) {
    function paiementMomo(Request $request)
    {
        $client = new Client();
        $env = strtolower(config('app.env'));
        if ($env === 'local')
            $url = 'http://localhost:8000/api/v1.0.0/momo/paid';
        else if ($env === 'staging')
            $url = 'https://www.staging.medicasure.com/api/v1.0.1/momo/paid';
        else
            $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.1/momo/paid';

        $args = array(
            'identifiant' => $request->get('identifiant'),
            'referenceId' => $request->referenceId,
            'phone' => $request->partyId,
            'amount' => $request->amount,
            'note' => 'Payement pour Medicasure',
            'message' => 'Medicasure',
        );
        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => json_encode($args),
        ]);
        return $res->getBody();
    }
}
if (!function_exists('paiementOM')) {
    function paiementOM(Request $request)
    {
        $client = new Client();
        $env = strtolower(config('app.env'));
        if ($env === 'local')
            $url = 'http://localhost:8000/api/v1.0.0/om/paid';
        else if ($env === 'staging')
            $url = 'https://www.staging.medicasure.com/api/v1.0.1/om/paid';
        else
            $url = 'https://redirections-medicasure.medsurlink.com/api/v1.0.1/om/paid';


        $args = array(
            'identifiant' => $request->get('identifiant'),
            'referenceId' => $request->referenceId,
            'phone' => $request->partyId,
            'amount' => $request->amount,
            'note' => 'Payement pour Medicasure',
            'message' => 'Medicasure',
        );

        $res = $client->request('POST', $url, [
            'auth' => [
                'EktzFuEm2Hrg92ZfmRzkeNcA2NYEeNVpjVcA4KdPVcyABvFmpUgFAE@medicasure.com',
                '4qaxvbvfUyseXybr973KTkrkESbRc9S6H8eqy5uCDGfpMkDTK74kTY'
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => json_encode($args),
        ]);
        // dd(json_encode($res));
        return $res->getBody();
    }
}
