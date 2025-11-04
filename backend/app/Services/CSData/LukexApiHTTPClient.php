<?php

namespace App\Services\CSData;

use App\Services\CSData\Interfaces\HasPrices;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;


/**
 * Для интеграции с https://github.com/LukeX404/
 */
class LukexApiHTTPClient implements HasPrices
{

    protected string $host;

    private const string CS_PRICES = 'cs2-prices-tracker/refs/heads/main/static/prices/latest.json';


    public function __construct()
    {
        /** @var string $host */
        $host = config('lukex_api.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [lukex_api.client.timeout]');
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
            throw new RuntimeException('Unexpected response from Lukex API');
        }

        return $response;
    }



    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getPrices(): array
    {
        return $this->makeRequest(
            method: 'GET',
            uri: self::CS_PRICES,
        );
    }
}


