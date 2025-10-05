<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:dispatch-check-lots')->everyFiveMinutes();
Schedule::command('app:import-stickers')->dailyAt('00:30');
Schedule::command('app:import-highlights')->dailyAt('00:30');
Schedule::command('app:import-keychains')->dailyAt('00:35');
Schedule::command('app:import-prices')->dailyAt('00:40');
