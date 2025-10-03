<?php

namespace App\Console\Commands;

use App\UseCases\ImportKeychainPricesJabka\Handler;
use Illuminate\Console\Command;

class ImportKeychainPricesJabkaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-keychain-prices-jabka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import keychain prices from jabka.skin';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
