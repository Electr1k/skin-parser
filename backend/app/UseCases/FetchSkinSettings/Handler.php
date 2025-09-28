<?php

namespace App\UseCases\FetchSkinSettings;

use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\SkinSettings\DTOs\AllDTO;
use Illuminate\Support\Collection;

readonly class Handler
{

    public function __construct(private SkinSettingsInterface $skinSettingsRepository){}

    public function handle(DataInput $dataInput): Collection
    {
        return $this->skinSettingsRepository->getAll(AllDTO::from($dataInput));
    }
}
