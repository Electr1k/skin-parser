<?php

namespace App\UseCases\ImportHighlights;

use App\Models\Highlight;
use App\Services\CSGOApiHTTPClient;

readonly class Handler
{
    public function __construct(private CSGOApiHTTPClient $apiHTTPClient){}


    public function handle(): void
    {
        $response = $this->apiHTTPClient->getItems();

        foreach ($response['items_game']['highlight_reels'] as $index => $highlightReel) {

            Highlight::query()
                ->updateOrCreate(
                    ['original_id' => $highlightReel['id']],
                    [
                        'id' => $index,
                        'tournament_event_id' => $highlightReel['tournament event id'],
                        'tournament_event_stage_id' => $highlightReel['tournament event stage id'],
                        'map' => $highlightReel['map'],
                        'tournament_event_team0_id' => $highlightReel['tournament event team0 id'],
                        'tournament_event_team1_id' => $highlightReel['tournament event team1 id'],
                    ]
                );
        }
    }
}
