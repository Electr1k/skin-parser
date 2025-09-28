<?php

namespace App\Repository\LotRepository;

use App\Models\Lot;
use App\Repository\Interfaces\LotInterface;
use Illuminate\Support\Collection;

class LotRepository implements LotInterface
{
    public function getIdsWithFloat(iterable $lotsCollection): Collection
    {
        return Lot::query()
            ->whereFloatIsNotNull()
            ->whereAIn($lotsCollection)
            ->pluck('a');
    }
}
