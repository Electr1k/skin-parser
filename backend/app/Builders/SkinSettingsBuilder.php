<?php

namespace App\Builders;

class SkinSettingsBuilder extends BaseBuilder
{

    public function whereActive(bool $value = true): self
    {
        return $this->where('is_active', $value);
    }


}
