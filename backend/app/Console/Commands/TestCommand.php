<?php

namespace App\Console\Commands;

use App\Jobs\CheckLotsJob;
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
        CheckLotsJob::dispatchIf(true, 100);

        $skinsForCheck = SkinSettings::query()
            ->where('is_active', true)
            ->get();

        foreach ($skinsForCheck as $skin) {
            CheckLotsJob::dispatch($skin);
        }

        return self::SUCCESS;
    }
}
