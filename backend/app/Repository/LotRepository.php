<?php

namespace App\Repository;

use App\Models\Lot;
use App\Repository\Interfaces\LotInterface;
use Illuminate\Support\Collection;

class LotRepository implements LotInterface
{
    public function getIdsNotExist(iterable $lotsCollection): Collection
    {
        return Lot::query()
            ->whereAIn($lotsCollection)
            ->pluck('a');
    }
}
