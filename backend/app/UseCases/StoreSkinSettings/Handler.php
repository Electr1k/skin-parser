<?php

namespace App\UseCases\StoreSkinSettings;

use App\Models\SkinSettings;
use Illuminate\Support\Collection;

readonly class Handler
{
    public function handle(DataInput $dataInput): Collection
    {
        return SkinSettings::query()->create($dataInput->toArray());
    }
}
