<?php

namespace App\UseCases\FetchLotsPaginated;

use App\Pagination\LotPagination;
use App\Repository\Interfaces\LotInterface;
use App\Repository\LotRepository\DTOs\PaginateDTO;

readonly class Handler
{

    public function __construct(private LotInterface $lotRepository){}

    public function handle(DataInput $dataInput): LotPagination
    {
        return $this->lotRepository->getPaginate(PaginateDTO::from($dataInput));
    }
}
