<?php

namespace App\Services;

use App\Models\Lot;
use App\Models\SkinSettings;
use App\Repository\LotRepository;

readonly class LotService
{

    public function __construct(private LotRepository $lotRepository){}


    /**
     * Возвращает идентификтаоры лотов, которых нет в БД
     */
    public function filterNotExistLots(array $lots): array
    {
        $lotsCollection = collect($lots)->pluck('a');
        $lotsInDb = $this->lotRepository->getIdsNotExist($lotsCollection);
        return $lotsCollection->diff($lotsInDb)->toArray();
    }


    // TODO: рефакторинг - добавить DTO
    public function createOrUpdateLot(array $data, SkinSettings $settings, int $offset, int $batchSize): Lot
    {
        $values = [
            'd' => $data['d'],
            'm' => $data['m'],
            'skin_id' => $settings->id,
            'price' => $data['price'] ?? null,
            'float' => $data['floatvalue'] ?? null,
            'stickers' => $data['stickers'] ?? null,
            'page' => intdiv($offset, $batchSize) + 1,
            'custom_name' => $data['customname'] ?? null,
            'price_dirty' => $data['price_dirty'],
            'inspect_link' => $data['inspect_link'],
        ];

        return Lot::query()->updateOrCreate(['a' => $data['a']], array_filter($values));
    }
}
