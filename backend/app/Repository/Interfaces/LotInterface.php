<?php

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface LotInterface
{
    public function getIdsWithFloat(iterable $lotsCollection): Collection;
}
