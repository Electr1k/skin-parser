<?php

namespace App\UseCases\ImportKeychains;

use App\Models\Highlight;
use App\Models\Keychain;
use App\Models\Rarity;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}


    public function handle(): void
    {
        $response = $this->apiHTTPClient->getKeychains();

        foreach ($response as $keychain) {
            $rarity = Rarity::query()
                ->updateOrCreate(
                    ['id' => $keychain['rarity']['id']],
                    [
                        'name' => $keychain['rarity']['name'],
                        'color' => $keychain['rarity']['color'],
                    ]
                );

            $isHighlight = $keychain['highlight'] ?? false;
            $highlightName = null;
            $highlightId = null;
            if ($isHighlight) {
                $highlightName = substr($keychain['id'], 10);
                $highlightId = Highlight::query()->where('original_id', $highlightName)->first()?->id;
            }

            Keychain::query()
                ->updateOrCreate(
                    ['original_name' => $isHighlight ? $highlightName : substr($keychain['original']['loc_name'], 10)],
                    [
                        'name' => $keychain['name'],
                        'id' => $keychain['def_index'],
                        'icon' => $keychain['image'],
                        'rarity_id' => $rarity->id,
                        'is_highlight' => $isHighlight,
                        'highlight_id' => $highlightId,
                    ]
                );
        }
    }
}
