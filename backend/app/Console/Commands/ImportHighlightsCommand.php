<?php

namespace App\Console\Commands;

use App\UseCases\ImportHighlights\Handler;
use Illuminate\Console\Command;

class ImportHighlightsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-highlights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import highlight';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
