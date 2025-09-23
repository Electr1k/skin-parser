<?php

namespace App\Console\Commands;

use App\UseCases\DispatchCheckLots\Handler;
use Illuminate\Console\Command;

class DispatchCheckLotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-check-lots';

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
        $handler->handle();

        return self::SUCCESS;
    }
}
