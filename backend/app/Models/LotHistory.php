<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * История лота
 *
 * @property int $id - Идентификатор события
 * @property int $lot_id - Идентификатор лота
 * @property array $before - Лот до изменений
 * @property array $changes - Изменения
 *
 * @property Lot $lot - Лот
 */
class LotHistory extends Model
{

    protected $table = 'lots_history';

    protected $fillable = [
        'lot_id',
        'before',
        'changes'
    ];

    protected $casts = [
        'before' => 'array',
        'changes' => 'array'
    ];

    public function lot(): BelongsTo{
        return $this->belongsTo(Lot::class, 'lot_id', 'a');
    }
}
