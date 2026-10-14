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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'adsense' => [
        'enabled' => (bool) env('ADSENSE_ENABLED', false),
        'preview' => (bool) env('ADSENSE_PREVIEW', false),
        'client' => env('ADSENSE_CLIENT', 'ca-pub-1701186115041469'),
        'hidden_for_roles' => ['superadmin', 'developer'],
        'slots' => [
            'display' => env('ADSENSE_SLOT_DISPLAY', '3525776996'),
            'in-article' => env('ADSENSE_SLOT_IN_ARTICLE', '5880477598'),
            'feed' => env('ADSENSE_SLOT_FEED', '3685559099'),
            'multiplex' => env('ADSENSE_SLOT_MULTIPLEX', '6195252491'),
        ],
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
