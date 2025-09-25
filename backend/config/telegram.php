<?php

declare(strict_types=1);

return [
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'chat_id' => env('TELEGRAM_CHAT_ID'),
    'host' => env('TELEGRAM_HOST', 'https://api.telegram.org/bot'),
];
