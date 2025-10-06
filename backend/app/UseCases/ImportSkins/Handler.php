<?php

namespace App\UseCases\ImportSkins;

use App\Models\Skin;
use App\Models\Wear;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}

    public function handle(): void
    {
        $response = $this->apiHTTPClient->getSkins();

        foreach ($response as $skin) {
            $wears = [];

            foreach ($skin['wears'] ?? [] as $wear) {
                $wearModel = Wear::query()->updateOrCreate(['id' => $wear['id']], ['name' => $wear['name']]);
                $wears[] = $wearModel->id;
            }

            $skin = Skin::query()->updateOrCreate(['name' => $skin['name']],
                [
                    'min_float' => $skin['min_float'],
                    'max_float' => $skin['max_float'],
                    'icon' => $skin['image'],
                ]
            );

            $skin->wears()->sync($wears);
        }
    }
}
