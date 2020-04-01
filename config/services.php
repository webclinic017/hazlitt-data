<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
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

    'commodity' => [
        'spot' => env('SPOT_URL'),
    ],

    'quandl' => [
        'key' => env('QUANDL_API_KEY'),
        'url' => 'https://www.quandl.com/api/v3/datasets/'
    ],  
    
    'iex' => [
        'public' => env('IEX_CLOUD_PUBLIC_KEY'),
        'secret' => env('IEX_CLOUD_SECRET_KEY'),
    ],  

    'worldbank' => [
        'url' => 'https://api.worldbank.org/v2/country/'
    ]

];
