<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'teleconsultations' => [
        // 'base_uri' => env('TELECONSULTATIONS_SERVICE_BASE_URI', "http://localhost:8002"),
        'base_uri' => env('TELECONSULTATIONS_SERVICE_BASE_URI', "http://staging-back-teleconsultations.medsurlink.com"),
        //'base_uri' => env('TELECONSULTATIONS_SERVICE_BASE_URI', "http://back-teleconsultations.medsurlink.com"),
        'secret' => env('TELECONSULTATIONS_SERVICE_SECRET', "EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr"),
    ],
    'alertes' => [
        // 'base_uri' => env('ALERTES_SERVICE_BASE_URI', "http://localhost:8003"),
        'base_uri' => env('ALERTES_SERVICE_BASE_URI', "http://staging-alertes.medsurlink.com"),
        //'base_uri' => env('ALERTES_SERVICE_BASE_URI', "http://back-alertes.medsurlink.com"),
        'secret' => env('ALERTES_SERVICE_SECRET', "EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr"),
    ]

];
