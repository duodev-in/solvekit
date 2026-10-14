<?php

return [
    'groups' => [
        'dashboard' => [
            'description' => 'Access to administrative overview metrics and activity.',
            'permissions' => [
                'view dashboard' => ['description' => 'View the administration dashboard.', 'scope' => 'read'],
            ],
        ],
        'users' => [
            'description' => 'Manage administrator and developer accounts.',
            'permissions' => [
                'manage users' => ['description' => 'Create, edit, suspend, and delete users.', 'scope' => 'critical'],
            ],
        ],
        'roles' => [
            'description' => 'Control roles and access permissions.',
            'permissions' => [
                'manage roles' => ['description' => 'Create roles and assign permissions.', 'scope' => 'critical'],
            ],
        ],
        'audit logs' => [
            'description' => 'Review changes made across the administration area.',
            'permissions' => [
                'view audit logs' => ['description' => 'View the audit history.', 'scope' => 'sensitive'],
            ],
        ],
        'bug reports' => [
            'description' => 'Review and process public bug reports.',
            'permissions' => [
                'view bug reports' => ['description' => 'View submitted bug reports.', 'scope' => 'read'],
                'manage bug reports' => ['description' => 'Update bug report status and notes.', 'scope' => 'write'],
            ],
        ],
        'feature requests' => [
            'description' => 'Review and process public feature requests.',
            'permissions' => [
                'view feature requests' => ['description' => 'View submitted feature requests.', 'scope' => 'read'],
                'manage feature requests' => ['description' => 'Update feature request status and notes.', 'scope' => 'write'],
                'submit feature requests' => ['description' => 'Submit feature requests from public pages.', 'scope' => 'write'],
            ],
        ],
        'contact messages' => [
            'description' => 'Review and respond to contact messages.',
            'permissions' => [
                'view contact messages' => ['description' => 'View contact messages.', 'scope' => 'read'],
                'manage contact messages' => ['description' => 'Update contact message status.', 'scope' => 'write'],
                'reply to contact messages' => ['description' => 'Send replies to contact messages.', 'scope' => 'sensitive'],
            ],
        ],
    ],

    'roles' => [
        'superadmin' => '*',
        'developer' => [
            'view dashboard',
            'view bug reports',
            'manage bug reports',
            'view feature requests',
            'manage feature requests',
            'view contact messages',
            'manage contact messages',
            'reply to contact messages',
        ],
    ],
];
