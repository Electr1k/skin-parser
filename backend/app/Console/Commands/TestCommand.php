<?php

namespace App\Console\Commands;

use App\Events\LotIsRare;
use App\Jobs\CheckLotsJob;
use App\Models\Lot;
use App\Models\SkinSettings;
use App\UseCases\DispatchCheckLots\Handler;
use Illuminate\Console\Command;

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
        $lot = Lot::query()->whereNotNull('stickers')->first();

        event(new LotIsRare($lot));

        return self::SUCCESS;
    }
}
