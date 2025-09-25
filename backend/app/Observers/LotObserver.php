<?php

namespace App\Observers;

use App\Models\Lot;
use App\Models\LotHistory;

class LotObserver
{

    public function updating(Lot $lot): void
    {
        LotHistory::query()->create([
            'lot_id' => $lot->a,
            'before' => $lot->getOriginal(),
            'changes' => $lot->getDirty(),
        ]);
    }
}
