<?php

namespace App\Services\Lot;

use App\DTO\Lot\LotStoreDTO;
use App\Models\Lot;
use App\Models\SkinSettings;
use App\Repository\Interfaces\LotInterface;

readonly class LotService
{

    public function __construct(private LotInterface $lotRepository){}


    /**
     * Возвращает идентификтаоры лотов, которых нет в БД
     */
    public function filterNotExistLots(array $lots): array
    {
        $lotsCollection = collect($lots)->pluck('a');
        $lotsInDb = $this->lotRepository->getIdsNotExist($lotsCollection);
        return $lotsCollection->diff($lotsInDb)->toArray();
    }


    public function createOrUpdateLot(LotStoreDTO $dto): Lot
    {
        return Lot::query()->updateOrCreate(['a' => $dto->a], $dto->toArray());
    }
}
