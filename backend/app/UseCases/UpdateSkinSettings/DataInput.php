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
        public readonly string $name,
        public readonly float $maxPrice,
        public readonly bool $isActive = true,
        public readonly float|null $floatLimit = null,
        public readonly Extremum|null $extremum = null,
        public readonly float|null $min_stickers_price = null,
        public readonly float|null $min_keychains_price = null,
    ){}
}
