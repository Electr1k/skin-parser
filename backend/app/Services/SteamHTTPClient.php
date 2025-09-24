<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SteamHTTPClient
{

    protected string $host;
    protected int $timeout;

    protected const string URI_MARKET_LISTING_720 = '/market/listings/730/';


    public function __construct()
    {
        /** @var string $host */
        $host = config('steam.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [steam.client.host]');
        }
        $this->host = $host;

        $timeout = config('steam.client.timeout');
        if (! $timeout) {
            throw new RuntimeException('Empty config [steam.client.timeout]');
        }
        if (! is_int($timeout)) {
            throw new RuntimeException('Config [steam.client.timeout] must be int');
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
        array $additionalHeaders = [],
        array $queryParameters = [],
        ?string $proxy = null
    ): array {
        $options = [];

        $headers = [
            'Accept' => 'text/javascript, text/html, application/xml, text/xml, */*',
            'Accept-Encoding' => 'gzip, deflate, br, zstd',
            'Accept-Language' => 'ru-RU,ru;q=0.9',
            'Cache-Control' => 'max-age=0',
            'Connection' => 'keep-alive',
            'Cookie' => 'sessionid=b18a8d237a2979174b6e4451; steamCountry=NL%7Cee0948ac367a023272345c9fc51f21cf; steamCurrencyId=5; timezoneOffset=10800,0',
            'Host' => 'steamcommunity.com',
            'Referer' => $this->host.$uri,
            'Sec-Ch-Ua' => '"Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"',
            'Sec-Ch-Ua-Mobile' => '?0',
            'Sec-Ch-Ua-Platform' => 'Linux',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-origin',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36',
            'X-Prototype-Version' => '1.7',
            'X-Requested-With' => 'XMLHttpRequest'
        ];

        if ($proxy) {
            $options['proxy'] = $proxy;
        }

        $response = Http::baseUrl($this->host)
            ->timeout($this->timeout)
            ->withOptions($options)
            ->withQueryParameters($queryParameters)
            ->withHeaders($headers)
            ->withHeaders($additionalHeaders)
            ->send($method, $uri, ['json' => $data])
            ->throw()
            ->json();

        if ($response === null) {
            return [];
        }

        if (! is_array($response)) {
            throw new RuntimeException('Unexpected response from Steam API');
        }

        return $response;
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getSkinLots(
        string $skinId,
        int $offset = 0,
        int $batchSize = 100,
        ?string $proxy = null,
        string $country = 'RU',
        string $language = 'russian',
        int $currency = 5
    ): array {
        return $this->makeRequest(
            method: 'GET',
            uri: self::URI_MARKET_LISTING_720.$skinId.'/render/',
            queryParameters: [
                'start' => $offset,
                'count' => $batchSize,
                'country' => $country,
                'language' => $language,
                'currency' => $currency,
            ],
            proxy: $proxy
        );
    }
}


