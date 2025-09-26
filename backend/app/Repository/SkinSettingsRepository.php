<?php

namespace App\Repository;

use App\Models\SkinSettings;
use App\Repository\Interfaces\SkinSettingsInterface;
use Illuminate\Support\Collection;

class SkinSettingsRepository implements SkinSettingsInterface
{
    public function getActive(): Collection
    {
        return SkinSettings::query()
            ->whereActive()
            ->get();
    }
}
