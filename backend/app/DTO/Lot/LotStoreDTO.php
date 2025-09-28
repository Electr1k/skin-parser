<?php

namespace App\DTO\Lot;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class LotStoreDTO extends Data
{
    public function __construct(
        public readonly string $a,
        public readonly string $d,
        public readonly string $m,
        public readonly string $skinId,
        public readonly int $page,
        public readonly string $priceDirty,
        public readonly string $inspectLink,
        public readonly string|Optional $price = new Optional,
        #[MapInputName('floatvalue')]
        public readonly float|Optional $float = new Optional,
        public readonly array|Optional $stickers = new Optional,
        #[MapInputName('customname')]
        public readonly string|Optional $customName = new Optional,
    )
    {}
}
