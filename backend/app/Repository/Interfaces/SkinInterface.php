<?php

namespace App\Repository\Interfaces;

use App\Repository\Skin\DTOs\AllDTO;
use Illuminate\Support\Collection;

interface SkinInterface
{
    public function getAll(AllDTO $dto): Collection;

}
