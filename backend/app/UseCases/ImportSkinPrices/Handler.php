<?php

namespace App\UseCases\ImportSkinPrices;

use App\Models\Price;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}

    public function handle(): void
    {
        $response = $this->apiHTTPClient->getPrices();

        foreach ($response as $name => $prices) {
            Price::query()
                ->updateOrCreate(
                    ['name' => $name],
                    [
                        'last_24h' => $prices['steam']['last_24h'] ?? null,
                        'last_7d' => $prices['steam']['last_7d'] ?? null,
                        'last_30d' => $prices['steam']['last_30d'] ?? null,
                        'last_90d' => $prices['steam']['last_90d'] ?? null,
                        'last_ever' => $prices['steam']['last_ever'] ?? null,
                    ]
                );
        }
    }
}
