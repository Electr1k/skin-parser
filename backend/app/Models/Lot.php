<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Лот скина в стиме
 * @property integer $a - PK
 * @property integer $d
 * @property integer $m
 * @property string $skin_id - Идентификатор скина из настроек
 * @property float|null $price - Цена
 * @property float|null $float - Float
 * @property array|null $stickers - Стикеры
 * @property integer $page - Номер страницы, на которой находился лот
 * @property string|null $custom_name - Наймтег
 * @property string $price_dirty - Цена до нормализации
 * @property string $inspect_link - Ссылка на осмотр
 *
 * @property SkinSettings $skinSettings
 */
class Lot extends Model
{
    protected $primaryKey = 'a';
    public $incrementing = false;
    protected $guarded = [];

    protected $casts = [
        'stickers' => 'array',
    ];


    public function skinSettings(): BelongsTo
    {
        return $this->belongsTo(SkinSettings::class, 'skin_id');
    }
}
