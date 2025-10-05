<?php

namespace App\Models;

use App\Builders\SkinSettings\SkinSettingsBuilder;
use App\Enums\Extremum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;


/**
 * Настройки поиска скинов
 *
 * @property string $id - Идентификатор (slug) скина для поиска
 * @property string $market_hash_name - Название скина на латинице
 * @property string $market_name - Название скина на кириллице
 * @property string|null $icon - Иконка скина
 * @property Extremum $extremum - Предел, к которому стримится float (MIN, MAX)
 * @property float $float_limit - Пороговое значение float
 * @property float $max_price - Максимальная цена для поиска
 * @property bool $is_active - Активен ли поиск
 *
 * @property Collection<Lot> $lots
 * @method static SkinSettingsBuilder query()
 */
class SkinSettings extends Model
{

    use HasCustomBuilder;

    protected $table = 'skin_settings';
    public $incrementing = false;

    protected $keyType = 'string';
    protected $guarded = false;

    protected $casts = [
        'extremum' => Extremum::class,
        'float_limit' => 'float',
        'max_price' => 'float',
    ];

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class, 'skin_id');
    }
}
