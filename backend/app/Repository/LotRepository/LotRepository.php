<?php

namespace App\Repository\LotRepository;

use App\Enums\Extremum;
use App\Enums\LotsSortable;
use App\Models\Lot;
use App\Pagination\LotPagination;
use App\Repository\Interfaces\LotInterface;
use App\Repository\LotRepository\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LotRepository implements LotInterface
{
    public function getIdsWithFloat(iterable $lotsCollection): Collection
    {
        return Lot::query()
            ->whereFloatIsNotNull()
            ->whereAIn($lotsCollection)
            ->pluck('a');
    }

    public function getPaginate(PaginateDTO $dto): LotPagination
    {
        $isRareSql = "float IS NOT NULL AND skin_settings.extremum = '" . Extremum::MIN->value . "' AND float < float_limit
                        OR float IS NOT NULL AND skin_settings.extremum = '" . Extremum::MAX->value . "' AND float > float_limit";
        $query = Lot::query()
            ->leftJoin('skin_settings', 'skin_settings.id', '=', 'lots.skin_id')
            ->select([
                'icon',
                'market_name',
                'float',
                'price',
                DB::raw("lots.created_at as founded_at"),
                'stickers',
                DB::raw("$isRareSql AS is_rare")
            ]);

        $dto->skinId && $query->whereSkinId($dto->skinId);
        $dto->sortBy !== LotsSortable::DATE ? $query->orderBy($dto->sortBy->value) : $query->orderByDesc('lots.created_at');
        $dto->isRare && $query->whereRaw("$isRareSql");

        $paginator = $query->paginate(perPage: $dto->perPage, page: $dto->page);

        $rareCountQuery = Lot::query()
            ->leftJoin('skin_settings', 'skin_settings.id', '=', 'lots.skin_id')
            ->whereRaw($isRareSql);

        $dto->skinId && $rareCountQuery->whereSkinId($dto->skinId);

        $totalRareCount = $rareCountQuery->count();

        return new LotPagination(
            $paginator->items(),
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            rareCount: $totalRareCount
        );
    }
}
