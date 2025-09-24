<?php

declare(strict_types=1);

return [
    'client' => [
        'host' => env('STEAM_CLIENT_HOST', 'https://steamcommunity.com'),
        'timeout' => env('STEAM_CLIENT_TIMEOUT_SECONDS', 30),
        'batch_size' => env('STEAM_CLIENT_BATCH_SIZE', 100),
        'proxy' => env('STEAM_CLIENT_PROXY'),
    ],
];
