<?php

namespace App\Repository\SkinSettings\DTOs;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class PaginateDTO extends Data
{
    public function __construct(
        public readonly ?string $query = null,
        public readonly ?bool $isActive = null,
        public readonly int $page = 1,
        public readonly int $perPage = 10,
    ){}
}
