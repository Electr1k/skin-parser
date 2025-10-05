<?php

namespace App\UseCases\FetchLotsPaginated;

use App\Models\Lot;
use App\Pagination\LotPagination;
use App\Repository\Interfaces\LotInterface;
use App\Repository\LotRepository\DTOs\PaginateDTO;

readonly class Handler
{

    public function __construct(private LotInterface $lotRepository){}

    public function handle(DataInput $dataInput): LotPagination
    {
        $pagination = $this->lotRepository->getPaginate(PaginateDTO::from($dataInput));

        $additionalStickersData = $this->lotRepository->getLotsWithStickers($pagination->pluck('d'));

        $pagination->map(function (Lot $lot) use ($additionalStickersData) {
            $stickers = $additionalStickersData->firstWhere('d', $lot->d);

            $lot->stickers = $stickers?->stickers ?? $lot->stickers;
            $lot->stickers_price = (float) $stickers?->stickers_price ?? 0;
        } );

        return $pagination;
    }
}
