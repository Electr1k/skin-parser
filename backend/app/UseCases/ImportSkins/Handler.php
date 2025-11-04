<?php

namespace App\UseCases\ImportSkins;

use App\Models\Skin;
use App\Services\CSData\MykelApiHTTPClient;

readonly class Handler
{
    public function __construct(private MykelApiHTTPClient $apiHTTPClient){}

    public function handle(): void
    {
        $response = $this->apiHTTPClient->getSkins();

        foreach ($response as $skin) {

            Skin::query()->updateOrCreate(['name' => $skin->market_hash_name],
                [
                    'ru_name' => $skin->name,
                    'min_float' => $skin->min_float ?? null,
                    'max_float' => $skin->max_float ?? null,
                    'icon' => $skin->image,
                ]
            );

        }
    }
}
