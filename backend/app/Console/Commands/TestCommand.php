<?php

namespace App\Console\Commands;

use App\Enums\Extremum;
use App\Models\SearchSettings;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = SearchSettings::query()->create([
            'id' => 'MAC-10%20%7C%20Candy%20Apple%20(Factory%20New)',
            'market_hash_name' => "MAC-10 | Candy Apple (Factory New)",
            'market_name' => 'MAC-10 | Карамельное яблоко (Прямо с завода)',
            'icon' => 'https://steamcommunity.com/economy/image/i0CoZ81Ui0m-9KwlBY1L_18myuGuq1wfhWSaZgMttyVfPaERSR0Wqmu7LAocGIGz3UqlXOLrxM-vMGmW8VNxu5Dx60noTyL8n5WxrR1I4M28baBSLPmUBnPemLZw4rk6Gi3gxkp_5W3Qmdv_cnrDPwZ1Asd2FOcM5BO4k4KxMe7h7xue1dzcbAPD_Q',
            'extremum' => Extremum::MAX,
            'float_limit' => 0.007,
            'max_price' => 100,
        ]);

        dd($settings->toArray());
    }
}
