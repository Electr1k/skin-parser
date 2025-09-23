<?php

namespace App\UseCases\CheckLots;

use App\Models\SearchSettings;

class Handler
{

    public function handle(SearchSettings $settings): void
    {
        $lastPrice = $offset = 0;

        do{

            return;

        }while($lastPrice <= $settings->max_price);
    }
}
