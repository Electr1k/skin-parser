<?php

namespace App\UseCases\DispatchCheckLots;

use App\Jobs\CheckLotsJob;
use App\Repository\Interfaces\SkinSettingsInterface;

class Handler
{
    public function handle(SkinSettingsInterface $skinSettings): void
    {
        $skinsForCheck = $skinSettings->getActive();

        foreach ($skinsForCheck as $skin) {
            CheckLotsJob::dispatch($skin);
        }
    }
}
