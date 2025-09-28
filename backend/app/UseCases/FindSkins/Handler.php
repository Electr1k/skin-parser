<?php

namespace App\UseCases\FindSkins;

use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\SkinSettings\DTOs\PaginateDTO;
use App\Services\SteamHTTPClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class Handler
{
    public function __construct(private SteamHTTPClient $client){}

    public function handle(DataInput $dataInput): Collection
    {
        return collect(array_map(fn(array $item) => (object) $item, $this->client->getSkins($dataInput->query)['results']));
    }
}
