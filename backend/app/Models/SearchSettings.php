<?php

namespace App\Models;

use App\Enums\Extremum;
use Illuminate\Database\Eloquent\Model;


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
 */
class SearchSettings extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = false;

}
