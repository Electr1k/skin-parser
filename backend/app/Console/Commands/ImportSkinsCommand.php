<?php

namespace App\Console\Commands;

use App\UseCases\ImportSkins\Handler;
use Illuminate\Console\Command;

class ImportSkinsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-skins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import skins';

    /**
     * Execute the console command.
     */
    public function handle(Handler $handler): int
    {
        $handler->handle();

        return self::SUCCESS;
    }
}
