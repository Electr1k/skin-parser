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

    public function getLotsWithStickersAndKeychains(iterable $lotIds): Collection
    {
        return Lot::query()
            ->select(
                'lots.a',
                DB::raw("(
                    SELECT JSON_AGG(
                        JSON_BUILD_OBJECT(
                            'slot', se->>'slot',
                            'sticker_id', se->>'stickerId',
                            'wear', se->>'wear',
                            'icon', s.icon,
                            'name', s.name,
                            'price', COALESCE(sp.last_24h, sp.last_7d, sp.last_30d, sp.last_90d, sp.last_ever, 0)
                        )
                    )
                    FROM JSON_ARRAY_ELEMENTS(lots.stickers::JSON) se
                    LEFT JOIN stickers s ON s.id = (se->>'stickerId')::INTEGER
                    LEFT JOIN prices sp ON sp.name = s.name
                    WHERE se->>'stickerId' IS NOT NULL
                ) AS stickers"),
                DB::raw("(
                    SELECT SUM(COALESCE(sp.last_24h, sp.last_7d, sp.last_30d, sp.last_90d, sp.last_ever, 0))
                    FROM JSON_ARRAY_ELEMENTS(lots.stickers::JSON) se
                    LEFT JOIN stickers s ON s.id = (se->>'stickerId')::INTEGER
                    LEFT JOIN prices sp ON sp.name = s.name
                    WHERE se->>'stickerId' IS NOT NULL
                ) AS stickers_price"),
                DB::raw("(
                    SELECT JSON_AGG(
                        JSON_BUILD_OBJECT(
                            'slot', ke->>'slot',
                            'pattern', ke->>'pattern',
                            'sticker_id', ke->>'sticker_id',
                            'icon', k.icon,
                            'name', k.name,
                            'price', COALESCE(kp.last_24h, kp.last_7d, kp.last_30d, kp.last_90d, kp.last_ever, 0)
                        )
                    )
                    FROM JSON_ARRAY_ELEMENTS(lots.keychains::JSON) ke
                    LEFT JOIN keychains k ON k.id = (ke->>'sticker_id')::INTEGER
                    LEFT JOIN prices kp ON kp.name = k.name
                    WHERE ke->>'sticker_id' IS NOT NULL
                ) AS keychains"),
                DB::raw("(
                    SELECT SUM(COALESCE(kp.last_24h, kp.last_7d, kp.last_30d, kp.last_90d, kp.last_ever, 0))
                    FROM JSON_ARRAY_ELEMENTS(lots.keychains::JSON) ke
                    LEFT JOIN keychains k ON k.id = (ke->>'sticker_id')::INTEGER
                    LEFT JOIN prices kp ON kp.name = k.name
                    WHERE ke->>'sticker_id' IS NOT NULL
                ) AS keychains_price")
            )
            ->whereIn('lots.a', $lotIds)
            ->toBase()
            ->get()
            ->map(static function (object $lot) {
                $lot->stickers = json_decode($lot->stickers, true);
                $lot->keychains = json_decode($lot->keychains, true);

                if (is_array($lot->stickers)){
                    foreach ($lot->stickers as $index => &$sticker){
                        $sticker['slot'] = $index;
                    }
                }
                return $lot;
            });
    }
}
