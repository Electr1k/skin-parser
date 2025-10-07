<?php

namespace App\Models;

use App\Builders\Skin\SkinBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * Скин CS2
 * @property string $name - Название скина
 * @property string $ru_name - Название скина на кириллице
 * @property float|null $min_float - Минимальное значение float
 * @property float|null $max_float - Максимальное значение float
 * @property string $icon - Иконка скина
 *
 * @method static SkinBuilder query()
 */
class Skin extends Model
{
    use HasCustomBuilder;

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = false;

}
