<?php

namespace App\UseCases\DispatchCheckLots;

use App\Jobs\CheckLotsJob;
use App\Models\SkinSettings;

class Handler
{
    public function handle(): void
    {
        $skinsForCheck = SkinSettings::query()
            ->where('is_active', true)
            ->get();

        foreach ($skinsForCheck as $skin) {
            CheckLotsJob::dispatch($skin);
        }
    }
}
