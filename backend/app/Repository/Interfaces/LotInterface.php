<?php

namespace App\Repository\Interfaces;

use App\Pagination\LotPagination;
use App\Repository\LotRepository\DTOs\PaginateDTO;
use Illuminate\Support\Collection;

interface LotInterface
{
    public function getIdsWithFloat(iterable $lotsCollection): Collection;

    public function getPaginate(PaginateDTO $dto): LotPagination;

    public function getLotsWithStickers(iterable $lotIds): Collection;
}
