<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;


/**
 * Для интеграции с jabka.skin
 */
class JabkaSkinHTTPClient
{

    protected string $host;
    protected int $timeout;

    protected const string API_STICKER = '/api/items/wiki/cs2/other-categories/sticker';

    protected const string API_CHARM = '/api/items/wiki/cs2/other-categories/charm';

    public function __construct()
    {
        /** @var string $host */
        $host = config('jabka_skin.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [jabka_skin.client.timeout]');
        }
        $this->host = $host;

        $timeout = config('jabka_skin.client.timeout');
        if (! $timeout) {
            throw new RuntimeException('Empty config [jabka_skin.client.timeout]');
        }
        if (! is_int($timeout)) {
            throw new RuntimeException('Config [jabka_skin.client.timeout] must be int');
        }
        $this->timeout = $timeout;
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    private function makeRequest(
        string $method,
        string $uri,
        array $data = [],
        array $queryParameters = [],
    ): array {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $response = Http::baseUrl($this->host)
            ->timeout($this->timeout)
            ->withQueryParameters($queryParameters)
            ->withHeaders($headers)
            ->send($method, $uri, ['json' => $data])
            ->throw()
            ->json();

        if ($response === null) {
            return [];
        }

        if (! is_array($response)) {
            throw new RuntimeException('Unexpected response from CSFloat API');
        }

        return $response;
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getStickers(int $page = 1, int $pageSize = 1000): array {
        return $this->makeRequest(
            method: 'GET',
            uri: self::API_STICKER,
            queryParameters: [
                'page' => $page,
                'pageSize' => $pageSize,
            ]
        );
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getKeychains(int $page = 1, int $pageSize = 1000): array {
        return $this->makeRequest(
            method: 'GET',
            uri: self::API_CHARM,
            queryParameters: [
                'page' => $page,
                'pageSize' => $pageSize,
            ]
        );
    }
}


