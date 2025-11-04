<?php

namespace App\Console\Commands;

use App\DTO\Lot\LotStoreDTO;
use App\Enums\Extremum;
use App\Events\LotIsRare;
use App\Jobs\CheckLotsJob;
use App\Models\Lot;
use App\Models\SkinSettings;
use App\Services\CSFloatHTTPClient;
use App\Services\Lot\LotService;
use App\UseCases\FetchLotsPaginated\DataInput;
use App\UseCases\FetchLotsPaginated\Handler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch jobs for check lots';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $lotService = app(LotService::class);
$CSFloatHTTPClient = app(CSFloatHTTPClient::class);

        $lot = [
            'inspect_link' => 'steam://rungame/730/76561202255233023/+csgo_econ_action_preview%20M659338661678259920A46531364647D146067419979905785',
            'a' => '63264362',
            'm' => '24522642',
            'd' => '5423534',
            'price_dirty' => '44.44 руб',
            'price' => 44.44
        ];

        $lotAdditionalAttributes = $CSFloatHTTPClient->getFloatByInspectLink($lot['inspect_link']);

        $lot = array_merge($lot, $lotAdditionalAttributes['iteminfo']);

        $dto = LotStoreDTO::from([
            ...$lot,
            'skin_id' => 'Charm | Die-cast AK',
            'page' => 1,
        ]);
        dump($dto);
        $lot = $lotService->createOrUpdateLot(
$dto
        );

        dump($lot);
        return self::SUCCESS;
    }
}
