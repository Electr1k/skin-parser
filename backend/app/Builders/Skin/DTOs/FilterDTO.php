<?php

namespace App\Builders\Skin\DTOs;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FilterDTO extends Data
{
    public function __construct(
        public readonly ?string $query = null,
    ){}
}
