<?php

namespace App\Builders\SkinSettings;

use App\Builders\BaseBuilder;
use App\Builders\SkinSettings\DTOs\FilterDTO;

class SkinSettingsBuilder extends BaseBuilder
{

    public function whereActive(bool $value = true): self
    {
        return $this->where('is_active', $value);
    }

    public function filter(FilterDTO $filter): self
    {
        $filter->query && $this->whereILikeTrim('market_name', $filter->query);
        $filter->isActive && $this->whereActive($filter->isActive);

        return $this;
    }
}
