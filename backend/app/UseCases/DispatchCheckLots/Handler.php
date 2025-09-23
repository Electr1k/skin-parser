<?php

namespace App\UseCases\DispatchCheckLots;

use App\Jobs\CheckLotsJob;
use App\Models\SearchSettings;

class Handler
{
    public function handle(): void
    {
        $skinsForCheck = SearchSettings::query()
            ->where('is_active', true)
            ->get();

        foreach ($skinsForCheck as $skin) {
            CheckLotsJob::dispatch($skin);
        }
    }
}
