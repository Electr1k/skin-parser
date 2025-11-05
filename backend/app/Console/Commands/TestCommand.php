<?php

namespace App\Console\Commands;

use App\Models\SkinSettings;
use App\Repository\LotRepository\LotRepository;
use App\UseCases\CheckLots\DataInput;
use App\UseCases\CheckLots\Handler;
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

        /** @var LotRepository $lot */
        $lot = app(LotRepository::class);


        $lot->getLotsWithStickers([
            '47535703705',
            '43462794005'
        ]);

        return self::SUCCESS;
    }
}
