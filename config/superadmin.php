<?php

return [
    'mail_recipient' => env('SUPERADMIN_MAIL_RECIPIENT', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    'statuses' => [
        'active',
        'inactive',
        'suspended',
    ],
];
