<?php

namespace App\Observers;

use App\Models\Lot;
use Illuminate\Support\Facades\Log;

class LotObserver
{

    public function updating(Lot $lot): void
    {
        $original = json_encode($lot->getOriginal());
        $dirty = json_encode($lot->getDirty());
        Log::info("Было: $original\nстало: $dirty");
    }
}
