<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Редкость предмета
 * @property string $id - Идентификатор
 * @property string $name - Название
 * @property string $color - Цвет
 */
class Rarity extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';
    protected $guarded = false;
}
