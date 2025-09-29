<?php

namespace App\UseCases\FetchSkinsSettingsPaginated;

use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\SkinSettings\DTOs\PaginateDTO;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class Handler
{
    public function __construct(private SkinSettingsInterface $skinSettingsRepository){}

    public function handle(DataInput $dataInput): LengthAwarePaginator
    {
        return $this->skinSettingsRepository->getPaginate(PaginateDTO::from($dataInput));
    }
}
