<?php

return [
        /*
    |--------------------------------------------------------------------------
    | Mapping des rôles vers les routes de redirection
    |--------------------------------------------------------------------------
    |
    | Chaque environnement peut avoir ses propres routes de redirection.
    | Cela permet de tester sur "local" ou "staging" sans impacter "production".
    |
    */
    'redirects' => [
        'local' => [
            1 => 'dev.dashboard',
            2 => 'admin.dashboard',
            3 => 'entrepreneur.dashboard',
            4 => 'employe.dashboard',
        ],
        'staging' => [
            1 => 'staging.dev.dashboard',
            2 => 'staging.admin.dashboard',
            3 => 'staging.entrepreneur.dashboard',
            4 => 'staging.employe.dashboard',
        ],
        'production' => [
            1 => 'dev.dashboard',
            2 => 'admin.dashboard',
            3 => 'entrepreneur.dashboard',
            4 => 'employe.dashboard',
        ],
    ],
];
