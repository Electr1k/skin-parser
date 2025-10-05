<?php

namespace App\Repository\LotRepository\DTOs;

use App\Enums\LotsSortable;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class PaginateDTO extends Data
{
    public function __construct(
        public readonly bool         $isRareFloat = false,
        public readonly LotsSortable $sortBy = LotsSortable::DATE,
        public readonly ?string      $skinId = null,
        public readonly int          $page = 1,
        public readonly int          $perPage = 10,
    ){}
}
