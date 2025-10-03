<?php

namespace App\UseCases\ImportKeychains;

use App\Models\Keychain;
use App\Models\Rarity;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}


    public function handle(): void
    {
        $response = $this->apiHTTPClient->getKeychains();

        foreach ($response as $sticker) {
            $rarity = Rarity::query()
                ->updateOrCreate(
                    ['id' => $sticker['rarity']['id']],
                    [
                        'name' => $sticker['rarity']['name'],
                        'color' => $sticker['rarity']['color'],
                    ]
                );

            Keychain::query()
                ->updateOrCreate(
                    ['id' => $sticker['def_index']],
                    [
                        'name' => $sticker['name'],
                        'original_name' => $sticker['original']['loc_name'],
                        'icon' => $sticker['image'],
                        'rarity_id' => $rarity->id,
                    ]
                );
        }
    }
}
