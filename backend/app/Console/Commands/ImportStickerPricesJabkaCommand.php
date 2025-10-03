<?php

namespace App\Console\Commands;

use App\UseCases\ImportStickerPricesJabka\Handler;
use Illuminate\Console\Command;

class ImportStickerPricesJabkaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-sticker-prices-jabka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import sticker prices from jabka.skin';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
