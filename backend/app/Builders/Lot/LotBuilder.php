<?php

namespace App\Builders\Lot;

use App\Builders\BaseBuilder;

class LotBuilder extends BaseBuilder
{

    public function whereAIn(iterable $ids): self
    {
        return $this->whereIn('a', $ids);
    }

    public function whereFloatIsNotNull(): self
    {
        return $this->whereNotNull('float');
    }

    public function whereSkinId(string $skinId): self
    {
        return $this->where('skin_id', $skinId);
    }
}
