<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Стикер CSMoney
 * @property int $id - Идентификатор
 * @property string $name - Название
 * @property string $original_name - Оригинальное название из файлов CS2
 * @property string $icon - Иконка стикера
 * @property string $rarity_id - Идентификатор редкости
 *
 * @property Price|null $price
 */
class Sticker extends Model
{
    protected $guarded = false;
    public $incrementing = false;

    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'name', 'name');
    }
}
