<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasCustomBuilder
{
    public function newEloquentBuilder($query): Builder
    {
        /** @var Builder<Model> */
        return new (str_replace('Models', 'Builders', static::class).'Builder')($query);
    }
}
