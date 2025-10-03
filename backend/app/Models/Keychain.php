<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Брелок
 * @property int $id - Идентификатор
 * @property string $name - Название
 * @property string $original_name - Оригинальное название из файлов CS2
 * @property string $icon - Иконка стикера
 * @property string $rarity_id - Идентификатор редкости
 */
class Keychain extends Model
{
    public $incrementing = false;

    protected $guarded = false;
}
