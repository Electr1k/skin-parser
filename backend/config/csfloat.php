<?php

declare(strict_types=1);

return [
    'client' => [
        'host' => env('CS_FLOAT_CLIENT_HOST', 'http://csgofloat'),
        'timeout' => env('CS_FLOAT_TIMEOUT_SECONDS', 30),
    ],
];
