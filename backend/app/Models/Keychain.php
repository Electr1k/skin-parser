<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Брелок
 * @property string $original_name - Оригинальное название из файлов CS2 [PK]
 * @property string $name - Название
 * @property int|null $id - Идентификатор (индекс из списка брелков CS2)
 * @property string $icon - Иконка стикера
 * @property string $rarity_id - Идентификатор редкости
 * @property bool $is_highlight - Брелок - хайлайт
 * @property int|null $highlight_id - Идентификатор хайлайта
 *
 * @property Price|null $price
 */
class Keychain extends Model
{
    public $incrementing = false;

    protected $guarded = false;

    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'name', 'name');
    }
}
