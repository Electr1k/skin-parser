<?php

namespace App\UseCases\UpdateSkinSettings;

use App\Enums\Extremum;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class DataInput extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $market_hash_name,
        public readonly string $market_name,
        public readonly string $icon,
        public readonly Extremum $extremum,
        public readonly float $floatLimit,
        public readonly float $maxPrice,
        public readonly bool $isActive = true,
    ){}
}
