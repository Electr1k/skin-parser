<?php

namespace App\Repository\SkinSettings;

use App\Builders\SkinSettings\DTOs\FilterDTO;
use App\Models\SkinSettings;
use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\SkinSettings\DTOs\AllDTO;
use App\Repository\SkinSettings\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SkinSettingsRepository implements SkinSettingsInterface
{
    public function getActive(): Collection
    {
        return SkinSettings::query()
            ->whereActive()
            ->get();
    }

    public function getAll(AllDTO $dto): Collection
    {
        return SkinSettings::query()
            ->filter(FilterDTO::from($dto))
            ->get();
    }

    public function getPaginate(PaginateDTO $dto): LengthAwarePaginator
    {
        return SkinSettings::query()
            ->filter(FilterDTO::from($dto))
            ->with(['skin', 'keychain', 'price'])
            ->orderBy('created_at', 'desc')
            ->paginate(
                perPage: $dto->perPage,
                page: $dto->page
            );
    }
}
