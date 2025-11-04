<?php

namespace App\UseCases\CheckLots;

use App\DTO\Lot\LotStoreDTO;
use App\Enums\Extremum;
use App\Events\LotIsRare;
use App\Services\CSFloatHTTPClient;
use App\Services\HTMLParserService;
use App\Services\Lot\LotService;
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


    public function handle(DataInput $data): void
    {
        $totalCount = $offset = 0;

        do{
            $response = $this->steamHTTPClient->getSkinLots(
                $data->skin->uri,
                $offset,
                $this->batchSize,
                $this->proxy
            );

            if (! $totalCount) $totalCount = $response['total_count'];

            $lots = $this->htmlParserService->parseSteamLots($response['results_html']);
            $lotIdsForCheck = $this->lotService->filterNotExistLots($lots);

            foreach ($lots as $lot) {
                if ($lot['price'] > $data->skin->max_price) break(2);

                if (in_array($lot['a'], $lotIdsForCheck)) {
                    try {
                        $lotAdditionalAttributes = $this->CSFloatHTTPClient->getFloatByInspectLink($lot['inspect_link']);

                        $lot = array_merge($lot, $lotAdditionalAttributes['iteminfo']);
                    }
                    catch (\Exception $exception){
                        Log::error($exception->getMessage());
                    }
                }

                $lot = $this->lotService->createOrUpdateLot(
                    LotStoreDTO::from([
                        ...$lot,
                        'skin_id' => $data->skin->name,
                        'page' => intdiv($offset, $this->batchSize) + 1,
                    ])
                );

                if (in_array($lot->a, $lotIdsForCheck) && $lot->float && (
                    $data->skin->extremum === Extremum::MIN && $lot->float < $data->skin->float_limit ||
                    $data->skin->extremum === Extremum::MAX && $lot->float > $data->skin->float_limit)
                ) {
                    event(new LotIsRare($lot));
                }

                // TODO: подумать если стикеры изменятся
                if (in_array($lot->a, $lotIdsForCheck) && $lot->stickersPrice() > 4) {
                    event(new LotIsRare($lot));
                }

                if (in_array($lot->a, $lotIdsForCheck) && $lot->stickersPrice() > 4)
            }
            $offset += $this->batchSize;

            // TODO: Подумать над Rate limit
            sleep(15);
        }while ($offset < $totalCount);
    }
}
