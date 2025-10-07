<?php

namespace App\Models;

use App\Builders\Price\PriceBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Цена на скин
 * @property string $name - Название скина
 * @property float|null $last_24h - Медианная цена за 24ч в Steam'
 * @property float|null $last_7d - Медианная цена за 7д в Steam'
 * @property float|null $last_30d - Медианная цена за 30д в Steam'
 * @property float|null $last_90d - Медианная цена за 90д в Steam'
 * @property float|null $last_ever - Медианная цена за все время в Steam'
 *
 * @property float $price - Текущая цена
 * @method static PriceBuilder query()
 */
class Price extends Model
{
    use HasCustomBuilder;

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = false;

    public function price(): Attribute
    {
        return new Attribute(
            get: fn() => round($this->last_24h ?? $this->last_7d ?? $this->last_30d ?? $this->last_90d ?? $this->last_ever ?? 0, 2)
        );
    }
}
