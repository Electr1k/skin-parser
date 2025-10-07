<?php

namespace App\Repository\LotRepository;

use App\Enums\Extremum;
use App\Enums\LotsSortable;
use App\Models\Lot;
use App\Pagination\LotPagination;
use App\Repository\Interfaces\LotInterface;
use App\Repository\LotRepository\DTOs\PaginateDTO;
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
            ->leftJoin('skin_settings', 'skin_settings.name', '=', 'lots.skin_id')
            ->leftJoin('skins', 'skins.name', '=', 'lots.skin_id')
            ->select([
                '*',
                DB::raw("lots.created_at as founded_at"),
                DB::raw("$isRareFloatSql AS is_rare_float")
            ]);

        $dto->skinId && $query->whereSkinId($dto->skinId);
        $dto->sortBy !== LotsSortable::DATE ? $query->orderBy($dto->sortBy->value) : $query->orderByDesc('lots.created_at');
        $dto->isRareFloat && $query->whereRaw("$isRareFloatSql");

        $paginator = $query->paginate(perPage: $dto->perPage, page: $dto->page);

        $rareCountQuery = Lot::query()
            ->leftJoin('skin_settings', 'skin_settings.name', '=', 'lots.skin_id')
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
        $subQuery = Lot::query()
            ->select([
                'lots.a',
                DB::raw("ROW_NUMBER() OVER (PARTITION BY lots.a ORDER BY s.name) - 1 as slot"),
                DB::raw("(item->>'stickerId')::int as sticker_id"),
                's.name',
                's.icon',
                DB::raw("CASE WHEN item->'wear' IS NULL THEN '0' ELSE item->>'wear' END as wear"),
                DB::raw("ROUND(COALESCE(p.last_24h, p.last_7d, p.last_30d, p.last_90d, p.last_ever)::numeric, 2)::float as price")
            ])
            ->crossJoin(DB::raw('LATERAL jsonb_array_elements(lots.stickers) AS item'))
            ->leftJoin('stickers as s', DB::raw("(item->>'stickerId')::int"), '=', 's.id')
            ->leftJoin('prices as p', 's.name', '=', 'p.name')
            ->whereIn('lots.a', $lotIds);

        return DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery->getQuery())
            ->select([
                'a',
                DB::raw(
                "json_agg(
                    json_build_object(
                        'slot', slot,
                        'stickerId', sticker_id,
                        'name', name,
                        'icon', icon,
                        'wear', wear,
                        'price', price
                    )
                ) as stickers"),
                DB::raw("ROUND(SUM(CASE WHEN wear = '0' THEN price ELSE 0 END)::numeric, 2) as stickers_price")
            ])
            ->groupBy('a')
            ->get()
            ->map(function ($lot){ $lot->stickers = json_decode($lot->stickers); return $lot;});
    }
}
