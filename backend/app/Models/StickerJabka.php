<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Стикер jabka.skin
 * @property int $id - Идентификатор
 * @property string $name - Название
 * @property float $price - Цена в Steam
 * @property float $price_jabka - Цена на jabka.skin
 * @property string[] $colors - Цвета стикера
 * @property string $icon - Иконка стикера
 */
class StickerJabka extends Model
{
    protected $guarded = false;
    public $incrementing = false;

    protected $table = 'stickers_jabka';

    protected $casts = [
        'price' => 'float',
        'price_jabka' => 'float',
        'colors' => 'array',
    ];
}
