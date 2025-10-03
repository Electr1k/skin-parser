<?php

namespace App\Console\Commands;

use App\UseCases\ImportKeychains\Handler;
use Illuminate\Console\Command;

class ImportKeychainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-keychains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import keychains';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
