<?php

namespace App\Repository\Interfaces;

use App\Repository\SkinSettings\DTOs\AllDTO;
use App\Repository\SkinSettings\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SkinSettingsInterface
{
    public function getActive(): Collection;

    public function getAll(AllDTO $dto): Collection;

    public function getPaginate(PaginateDTO $dto): LengthAwarePaginator;
}
