<?php

namespace App\UseCases\CheckLots;

use App\Models\SkinSettings;
use Spatie\LaravelData\Data;

class DataInput extends Data
{
    public function __construct(
        public readonly SkinSettings $skin,
    ){}
}
