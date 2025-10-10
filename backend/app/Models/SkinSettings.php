<?php

namespace App\Models;

use App\Builders\SkinSettings\SkinSettingsBuilder;
use App\Enums\Extremum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;


/**
 * Настройки поиска скинов
 *
 * @property string $name - Название скина для поиска
 * @property float $max_price - Максимальная цена для поиска
 * @property bool $is_active - Активен ли поиск
 * @property float|null $float_limit - Пороговое значение float
 * @property Extremum|null $extremum - Предел, к которому стримится float (MIN, MAX)
 * @property float|null $min_stickers_price - Минимальная стоимость стикеров
 * @property float|null $min_keychains_price - Минимальная стоимость брелков
 *
 * @property string $uri - Относительная ссылка на скина в Steam
 * @property float $currentPrice - Текущая цена в Steam
 * @property Skin $skin
 * @property Keychain $keychain
 * @property Collection<Lot> $lots
 * @property Price $price
 * @method static SkinSettingsBuilder query()
 */
class SkinSettings extends Model
{

    use HasCustomBuilder;

    protected $table = 'skin_settings';

    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';
    protected $guarded = false;

    protected $casts = [
        'extremum' => Extremum::class,
        'max_price' => 'float',
        'float_limit' => 'float',
        'min_stickers_price' => 'float',
        'min_keychains_price' => 'float',
    ];


    public function uri(): Attribute
    {
        return new Attribute(
            get: fn () => rawurlencode($this->name),
        );
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class, 'skin_id', 'name');
    }

    /**
     * @return HasOne<Price>
     */
    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'name', 'name');
    }

    /**
     * @return HasOne<Skin>
     */
    public function skin(): HasOne
    {
        return $this->hasOne(Skin::class, 'name', 'name');
    }

    /**
     * @return HasOne<Skin>
     */
    public function keychain(): HasOne
    {
        return $this->hasOne(Keychain::class, 'name', 'name');
    }
}
