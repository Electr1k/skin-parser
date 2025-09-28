<?php

namespace App\UseCases\DispatchCheckLots;

use App\Jobs\CheckLotsJob;
use App\Repository\Interfaces\SkinSettingsInterface;

readonly class Handler
{

    public function __construct(private SkinSettingsInterface $skinSettings){}

    public function handle(): void
    {
        $skinsForCheck = $this->skinSettings->getActive();

        foreach ($skinsForCheck as $skin) {
            CheckLotsJob::dispatch($skin);
        }
    }
}
