<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Цена на скин
 * @property string $name - Название скина
 * @property float|null $last_24h - Медианная цена за 24ч в Steam'
 * @property float|null $last_7d - Медианная цена за 7д в Steam'
 * @property float|null $last_30d - Медианная цена за 30д в Steam'
 * @property float|null $last_90d - Медианная цена за 90д в Steam'
 * @property float|null $last_ever - Медианная цена за все время в Steam'
 */
class Price extends Model
{
    protected $primaryKey = 'name';


    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = false;
}
