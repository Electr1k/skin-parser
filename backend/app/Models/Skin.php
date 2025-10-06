<?php

namespace App\Models;

use App\Builders\Skin\SkinBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Скин CS2
 * @property string $name - Название скина
 * @property float|null $min_float - Минимальное значение float
 * @property float|null $max_float - Максимальное значение float
 * @property string $icon - Иконка скина
 *
 * @property Collection<Wear> $wears - Качества скина
 * @method static SkinBuilder query()
 */
class Skin extends Model
{
    use HasCustomBuilder;

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = false;

    public function wears(): BelongsToMany
    {
        return $this->belongsToMany(Wear::class, 'skin_wear', 'skin_name', 'wear_id');
    }
}
