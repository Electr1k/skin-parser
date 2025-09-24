<?php

namespace App\UseCases\CheckLots;

use App\Models\SearchSettings;
use App\Services\CSFloatHTTPClient;
use App\Services\HTMLParserService;
use App\Services\SteamHTTPClient;
use Illuminate\Support\Facades\Log;

class Handler
{
    private int $batchSize;

    private ?string $proxy;

    public function __construct(
        private SteamHTTPClient $steamHTTPClient,
        private HTMLParserService $htmlParserService,
        private CSFloatHTTPClient $CSFloatHTTPClient,
    ){
        $this->batchSize = config('steam.client.batch_size');
        $this->proxy = config('steam.client.proxy');
    }


    public function handle(SearchSettings $settings): void
    {
        $totalCount = $offset = 0;

        do{
            $response = $this->steamHTTPClient->getSkinLots(
                $settings->id,
                $offset,
                $this->batchSize,
                $this->proxy
            );

            if (! $totalCount) $totalCount = $response['total_count'];
            $lots = $this->htmlParserService->parseSteamLots($response['results_html']);

            foreach ($lots as $lot) {
                if ($lot['price'] > $settings->max_price) break(2);
                try {
                    $lotAdditionalAttributes = $this->CSFloatHTTPClient->getFloatByInspectLink($lot['inspect_link']);

                    $lot = array_merge($lot, $lotAdditionalAttributes['iteminfo']);
                }
                catch (\Exception $exception){
                    Log::error($exception->getMessage());
                }
            }

            $offset += $this->batchSize;

            // TODO: Подумать над Rate limit
            sleep(5);
        }while ($offset < $totalCount);
    }


}
