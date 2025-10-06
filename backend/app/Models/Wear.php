<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Качество скина
 * @property string $id - Идентификатор
 * @property string $name - Название
 *
 * @property Collection<Skin> $skins - Скины
 */
class Wear extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = false;

    public function skins(): BelongsToMany
    {
        return $this->belongsToMany(Skin::class, 'wear_skin', 'wear_id', 'skin_name');
    }
}
