<?php

namespace App\Console\Commands;

use App\UseCases\ImportSkinPrices\Handler;
use Illuminate\Console\Command;

class ImportSkinPricesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-skin-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import skin prices';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
