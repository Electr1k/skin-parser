<?php

namespace App\UseCases\FindSkins;

use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\Skin\DTOs\AllDTO;
use App\Repository\Skin\SkinRepository;
use App\Repository\SkinSettings\DTOs\PaginateDTO;
use App\Services\SteamHTTPClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class Handler
{
    public function __construct(private SkinRepository $repository){}

    public function handle(DataInput $dataInput): Collection
    {

        return $this->repository->getAll(AllDTO::from($dataInput));
    }
}
