<?php

namespace App\Repository\Skin;

use App\Builders\SkinSettings\DTOs\FilterDTO;
use App\Models\Skin;
use App\Repository\Interfaces\SkinInterface;
use App\Repository\Skin\DTOs\AllDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SkinRepository implements SkinInterface
{

    public function getAll(AllDTO $dto): Collection
    {
        return Skin::query()
            ->filter(FilterDTO::from($dto))
            ->joinPrices()
            ->select([
                'skins.*',
                DB::raw('COALESCE(prices.last_24h, prices.last_7d, prices.last_30d, prices.last_90d, 0) as price'),
            ])
            ->get();
    }

}
