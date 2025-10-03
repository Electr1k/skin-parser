<?php

namespace App\UseCases\ImportStickers;

use App\Models\Rarity;
use App\Models\Sticker;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}


    public function handle(): void
    {
        $response = $this->apiHTTPClient->getStickers();

        foreach ($response as $sticker) {
            $rarity = Rarity::query()
                ->updateOrCreate(
                    ['id' => $sticker['rarity']['id']],
                    [
                        'name' => $sticker['rarity']['name'],
                        'color' => $sticker['rarity']['color'],
                    ]
                );

            Sticker::query()
                ->updateOrCreate(
                    ['id' => $sticker['def_index']],
                    [
                        'name' => $sticker['name'],
                        'original_name' => $sticker['original']['name'],
                        'icon' => $sticker['image'],
                        'rarity_id' => $rarity->id,
                    ]
                );
        }
    }
}
