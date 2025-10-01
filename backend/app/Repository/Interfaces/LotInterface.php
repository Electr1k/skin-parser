<?php

namespace App\Repository\Interfaces;

use App\Repository\LotRepository\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface LotInterface
{
    public function getIdsWithFloat(iterable $lotsCollection): Collection;

    public function getPaginate(PaginateDTO $dto): LengthAwarePaginator;
}
