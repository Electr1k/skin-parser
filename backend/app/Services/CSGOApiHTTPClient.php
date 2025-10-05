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

    private const string CSGO_API = '/CSGO-API/main/public/api';

    private const string CS_FILE_TRACKER = '/counter-strike-file-tracker/refs/heads/main/static/';

    private const string STEAM_PRICE_API = '/counter-strike-price-tracker/refs/heads/main/static';

    protected const string STICKERS = self::CSGO_API.'/en/stickers.json';

    protected const string KEYCHAINS = self::CSGO_API.'/en/keychains.json';

    protected const string ITEMS_GAME = self::CS_FILE_TRACKER.'/items_game.json';

    protected const string PRICES = self::STEAM_PRICE_API.'/prices/latest.json';


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

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getPrices(): array
    {
        return $this->makeRequest(
            method: 'GET',
            uri: self::PRICES,
        );
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getItems(): array
    {
        return $this->makeRequest(
            method: 'GET',
            uri: self::ITEMS_GAME,
        );
    }
}


