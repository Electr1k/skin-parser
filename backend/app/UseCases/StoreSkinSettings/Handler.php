<?php

namespace App\UseCases\StoreSkinSettings;

use App\Models\SkinSettings;

readonly class Handler
{
    public function handle(DataInput $dataInput): SkinSettings
    {
        return SkinSettings::query()->create([...$dataInput->toArray(), 'id' => rawurlencode($dataInput->market_hash_name)]);
    }
}
