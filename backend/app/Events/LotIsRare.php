<?php

namespace App\Events;

use App\Models\Lot;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Найден редкий float
 */
class LotIsRare
{
    use Dispatchable, SerializesModels;

    public function __construct(public Lot $lot){}
}
