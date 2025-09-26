<?php

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface LotInterface
{
    public function getIdsNotExist(iterable $lotsCollection): Collection;
}
