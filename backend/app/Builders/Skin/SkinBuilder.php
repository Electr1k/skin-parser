<?php

namespace App\Builders\Skin;

use App\Builders\BaseBuilder;
use App\Builders\SkinSettings\DTOs\FilterDTO;
use Illuminate\Support\Facades\DB;

class SkinBuilder extends BaseBuilder
{

    public function filter(FilterDTO $filter): self
    {
        $filter->query && $this->whereILikeTrim('skins.ru_name', $filter->query);
        return $this;
    }

    public function joinPrices(): self
    {
        return $this
            ->join('prices', 'prices.name', '=', 'skins.name');
    }

}
