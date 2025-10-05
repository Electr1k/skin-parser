<?php

namespace App\Console\Commands;

use App\Enums\Extremum;
use App\Events\LotIsRare;
use App\Jobs\CheckLotsJob;
use App\Models\Lot;
use App\Models\SkinSettings;
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
        $dataInput = new DataInput(perPage: 1000, );
        $data = $handler->handle($dataInput);
        dd($data->whereNotNull('stickers')->where('stickers', '!=', [])->toArray());
        return self::SUCCESS;
    }
}
