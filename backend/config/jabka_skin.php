<?php

declare(strict_types=1);

return [
    'client' => [
        'host' => env('JABKA_SKIN_CLIENT_HOST', 'https://jabka.skin'),
        'timeout' => env('JABKA_SKIN_TIMEOUT_SECONDS', 30),
        'batch_size' => env('JABKA_SKIN_BATCH', 1000),
    ],
];
