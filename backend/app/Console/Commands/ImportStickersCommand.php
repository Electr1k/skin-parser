<?php

namespace App\Console\Commands;

use App\UseCases\ImportStickers\Handler;
use Illuminate\Console\Command;

class ImportStickersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stickers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stickers';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
