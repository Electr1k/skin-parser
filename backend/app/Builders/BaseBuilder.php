<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Builder<Model>
 */
class BaseBuilder extends Builder
{
    public function whereILikeTrim(string $column, string $value): static
    {
        return $this->whereRaw("$column ILIKE '%' || TRIM('$value') || '%'");
    }
}
