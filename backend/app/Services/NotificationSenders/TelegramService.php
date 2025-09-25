<?php

namespace App\Services\NotificationSenders;


use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TelegramService implements NotificationSenderInterface
{
    private string $token;

    private string $chatId;

    private string $host;

    private const string SEND_MESSAGE = '/sendMessage';

    public function __construct()
    {
        $this->host = config('telegram.host');

        $botToken = config('telegram.bot_token');
        if (! $botToken) {
            throw new RuntimeException('Config [telegram.bot_token] is empty');
        }
        $this->token = $botToken;

        $chatId = config('telegram.chat_id');
        if (! $chatId) {
            throw new RuntimeException('Config [telegram.chat_id] is empty');
        }
        $this->chatId = $chatId;
    }


    /**
     * @throws RequestException|ConnectionException
     */
    private function makeRequest(
        string $method,
        string $uri,
        array $data = []
    ): array {

        $response = Http::baseUrl($this->host.$this->token)
            ->send($method, $uri, ['json' => $data])
            ->throw()
            ->json();

        return is_array($response) ? $response : [];
    }

    /**
     * @throws RequestException|ConnectionException
     */
    public function sendNotification(string $message): void
    {
        $data = [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        $this->makeRequest('POST', self::SEND_MESSAGE, $data);
    }
}
