<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CSFloatHTTPClient
{

    protected string $host;
    protected int $timeout;

    public function __construct()
    {
        /** @var string $host */
        $host = config('csfloat.client.host');
        if (! $host) {
            throw new RuntimeException('Empty config [csfloat.client.timeout]');
        }
        $this->host = $host;

        $timeout = config('csfloat.client.timeout');
        if (! $timeout) {
            throw new RuntimeException('Empty config [csfloat.client.timeout]');
        }
        if (! is_int($timeout)) {
            throw new RuntimeException('Config [csfloat.client.timeout] must be int');
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
    public function getFloatByInspectLink(string $inspectLink): array {
        return $this->makeRequest(
            method: 'GET',
            uri: '/',
            queryParameters: ['url' => $inspectLink,]
        );
    }
}


