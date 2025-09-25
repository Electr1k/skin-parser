<?php

namespace App\UseCases\CheckLots;

use App\Enums\Extremum;
use App\Models\SkinSettings;
use App\Services\CSFloatHTTPClient;
use App\Services\HTMLParserService;
use App\Services\LotService;
use App\Services\SteamHTTPClient;
use Illuminate\Support\Facades\Log;

class Handler
{
    private int $batchSize;

    private ?string $proxy;

    public function __construct(
        private readonly SteamHTTPClient $steamHTTPClient,
        private readonly HTMLParserService $htmlParserService,
        private readonly CSFloatHTTPClient $CSFloatHTTPClient,
        private readonly LotService $lotService,
    ){
        $this->batchSize = config('steam.client.batch_size');
        $this->proxy = config('steam.client.proxy');
    }


    public function handle(SkinSettings $skin): void
    {
        $totalCount = $offset = 0;

        do{
            $response = $this->steamHTTPClient->getSkinLots(
                $skin->id,
                $offset,
                $this->batchSize,
                $this->proxy
            );

            if (! $totalCount) $totalCount = $response['total_count'];

            $lots = $this->htmlParserService->parseSteamLots($response['results_html']);
            $lotIdsForCheck = $this->lotService->filterNotExistLots($lots);

            foreach ($lots as $lot) {
                if ($lot['price'] > $skin->max_price) break(2);

                if (in_array($lot['a'], $lotIdsForCheck)) {
                    try {
                        $lotAdditionalAttributes = $this->CSFloatHTTPClient->getFloatByInspectLink($lot['inspect_link']);

                        $lot = array_merge($lot, $lotAdditionalAttributes['iteminfo']);
                    }
                    catch (\Exception $exception){
                        Log::error($exception->getMessage());
                    }
                }

                $this->lotService->createOrUpdateLot($lot, $skin, $offset, $this->batchSize);

                if (isset($lot['floatvalue']) && (
                    $skin->extremum === Extremum::MIN && $lot['floatvalue'] < $skin->float_limit ||
                    $skin->extremum === Extremum::MAX && $lot['floatvalue'] > $skin->float_limit)
                ) {
                    dump('Найден предмет: float - ' . $lot['floatvalue'] . ' Price - ' . $lot['price'] . ' Page - ' . (intdiv($offset, $this->batchSize) + 1));
                    Log::warning('Найден предмет: float - ' . $lot['floatvalue'] . ' Price - ' . $lot['price'] . ' Page - ' . (intdiv($offset, $this->batchSize) + 1));
                    // TODO: notification about find
                }
            }
            $offset += $this->batchSize;

            // TODO: Подумать над Rate limit
            sleep(5);
        }while ($offset < $totalCount);
    }
}
