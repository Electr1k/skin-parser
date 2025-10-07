<?php

namespace App\Builders\Price;

use App\Builders\BaseBuilder;
use Illuminate\Support\Facades\DB;

class PriceBuilder extends BaseBuilder
{

    public function selectPrice(): self
    {
        return $this->addSelect(DB::raw("COALESCE(last_24h, last_7d, last_30d, last_90d, last_ever, 0) as price"));
    }

    public function priceValue(): float
    {
        return $this->rawValue("COALESCE(last_24h, last_7d, last_30d, last_90d, last_ever, 0)");
    }

}
