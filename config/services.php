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

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => '1998080447292926',
        'client_secret' => '983f407f13aa24eda965ef23c4217a60',
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'), // Vous pouvez définir le mode par défaut ici
        'currency' => env('PAYPAL_CURRENCY', 'USD'),
        'sandbox' => [
            'client_id'         => env('PAYPAL_CLIENT_ID'),
            'client_secret'     => env('PAYPAL_CLIENT_SECRET')
        ],
        'live' => [
            'client_id'         => env('PAYPAL_CLIENT_ID'),
            'client_secret'     => env('PAYPAL_CLIENT_SECRET') //,
            // 'app_id'            => '',
        ],
    ],
    'exchange_rate_api' => [
        'key' => 'c0b1eccdd8428725b0d70121',
    ],


];
