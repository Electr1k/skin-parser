<?php

namespace App\Builders\Skin;

use App\Builders\BaseBuilder;
use App\Builders\SkinSettings\DTOs\FilterDTO;
use Illuminate\Support\Facades\DB;

class SkinBuilder extends BaseBuilder
{

    public function filter(FilterDTO $filter): self
    {
        $filter->query && $this->whereILikeTrim('skins.name', $filter->query);
        return $this;
    }

    public function joinWearsAndPrices(): self
    {
        return $this
            ->join('skin_wear', 'skin_wear.skin_name', '=', 'skins.name')
            ->join('wears', 'wears.id', '=', 'skin_wear.wear_id')
            ->join('prices', 'prices.name', '=', DB::raw("skins.name || ' (' || wears.name || ')'"));
    }

}
