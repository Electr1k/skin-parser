<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;


/**
 * Для интеграции с https://github.com/ByMykel/CSGO-API/
 */
class CSGOApiHTTPClient
{

    protected string $host;

    protected const string STICKERS = '/en/stickers.json';

    protected const string KEYCHAINS = '/en/keychains.json';


    public function __construct()
    {
        /** @var string $host */
        $host = config('csgo_api.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [csgo_api.client.timeout]');
        }
        $this->host = $host;
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    private function makeRequest(
        string $method,
        string $uri,
    ): array {

        $response = Http::baseUrl($this->host)
            ->send($method, $uri)
            ->throw()
            ->json();

        if ($response === null) {
            return [];
        }

        if (! is_array($response)) {
            throw new RuntimeException('Unexpected response from CSGO API');
        }

        return $response;
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getStickers(): array {
        return $this->makeRequest(
            method: 'GET',
            uri: self::STICKERS,
        );
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getKeychains(): array {
        return $this->makeRequest(
            method: 'GET',
            uri: self::KEYCHAINS,
        );
    }
}


