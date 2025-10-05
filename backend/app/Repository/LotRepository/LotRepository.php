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
        $isRareFloatSql = "float IS NOT NULL AND skin_settings.extremum = '" . Extremum::MIN->value . "' AND float < float_limit
                        OR float IS NOT NULL AND skin_settings.extremum = '" . Extremum::MAX->value . "' AND float > float_limit";
        $query = Lot::query()
            ->leftJoin('skin_settings', 'skin_settings.id', '=', 'lots.skin_id')
            ->select([
                '*',
                DB::raw("lots.created_at as founded_at"),
                DB::raw("$isRareFloatSql AS is_rare_float")
            ]);

        $dto->skinId && $query->whereSkinId($dto->skinId);
        $dto->sortBy !== LotsSortable::DATE ? $query->orderBy($dto->sortBy->value) : $query->orderByDesc('lots.created_at');
        $dto->isRareFloat && $query->whereRaw("$isRareFloatSql");

        $paginator = $query->whereNotNull('stickers')->paginate(perPage: $dto->perPage, page: $dto->page);

        $rareCountQuery = Lot::query()
            ->leftJoin('skin_settings', 'skin_settings.id', '=', 'lots.skin_id')
            ->whereRaw($isRareFloatSql);

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

    public function getLotsWithStickers(iterable $lotIds): Collection
    {
        return Lot::query()
            ->crossJoin(DB::raw('LATERAL jsonb_array_elements(lots.stickers::jsonb) AS item'))
            ->leftJoin('stickers as s', DB::raw("(item->>'stickerId')::int"), '=', 's.id')
            ->leftJoin('prices as p', 's.name', '=', 'p.name')
            ->whereIn('lots.d', $lotIds)
            ->groupBy('d')
            ->select([
                'd',
                DB::raw("json_agg(
                    json_build_object(
                        'slot', (item->>'slot')::int,
                        'stickerId', (item->>'stickerId')::int,
                        'name', s.name,
                        'icon', s.icon,
                        'price', ROUND(COALESCE(
                            p.last_24h,
                            p.last_7d,
                            p.last_30d,
                            p.last_90d,
                            p.last_ever
                        )::numeric, 2)::float
                    )
                ) as stickers"),
                DB::raw("ROUND(SUM(COALESCE(p.last_24h, p.last_7d, p.last_30d, p.last_90d, p.last_ever))::numeric,2) as stickers_price")
            ])
            ->get();
    }
}
