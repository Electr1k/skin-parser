<?php

namespace App\Jobs;

use App\Models\SkinSettings;
use App\UseCases\CheckLots\DataInput;
use App\UseCases\CheckLots\Handler;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckLotsJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(protected SkinSettings $searchSettings) {}


    public function uniqueId(): string
    {
        return $this->searchSettings->id;
    }


    public function handle(Handler $handler): void
    {
        $handler->handle(new DataInput($this->searchSettings));
    }
}
