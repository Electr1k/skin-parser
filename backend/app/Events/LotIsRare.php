<?php

namespace App\Events;

use App\Models\Lot;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Найден редкий лот
 */
class LotIsRare
{
    use Dispatchable, SerializesModels;

    public function __construct(public Lot $lot){}
}
