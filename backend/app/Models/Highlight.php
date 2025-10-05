<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Хайлайт
 * @property string $original_id - Оригинальный идентификатор из файлов CS2
 * @property int $id - Порядоквый номер из списка хайлавтов (для csfloat)
 * @property int $tournament_event_id
 * @property int $tournament_event_stage_id
 * @property string $map
 * @property int $tournament_event_team0_id
 * @property int $tournament_event_team1_id
 */
class Highlight extends Model
{
    public $incrementing = false;

    protected $guarded = false;
}
