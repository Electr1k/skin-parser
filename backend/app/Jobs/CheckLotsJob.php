<?php

namespace App\Jobs;

use App\Models\SearchSettings;
use App\UseCases\CheckLots\Handler;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class CheckLotsJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable;
    use Queueable;
    use SerializesModels;

    public function __construct(protected SearchSettings $searchSettings) {}


    public function uniqueId(): string
    {
        return $this->searchSettings->id;
    }


    public function handle(Handler $handler): void
    {
        $handler->handle($this->searchSettings);
    }
}
