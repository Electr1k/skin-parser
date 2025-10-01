<?php

namespace App\UseCases\FetchLotsPaginated;

use App\Repository\Interfaces\LotInterface;
use App\Repository\LotRepository\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class Handler
{

    public function __construct(private LotInterface $lotRepository){}

    public function handle(DataInput $dataInput): LengthAwarePaginator
    {
        return $this->lotRepository->getPaginate(PaginateDTO::from($dataInput));
    }
}
