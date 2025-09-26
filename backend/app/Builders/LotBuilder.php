<?php

namespace App\Builders;

class LotBuilder extends BaseBuilder
{

    public function whereAIn(iterable $ids): self
    {
        return $this->whereIn('a', $ids);
    }


}
