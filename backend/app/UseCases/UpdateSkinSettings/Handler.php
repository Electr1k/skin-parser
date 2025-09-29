<?php

namespace App\UseCases\UpdateSkinSettings;

use App\Models\SkinSettings;
use Illuminate\Support\Collection;

readonly class Handler
{
    public function handle(DataInput $dataInput): bool
    {
        return SkinSettings::query()
            ->findOrFail($dataInput->id)
            ->update($dataInput->toArray());
    }
}
