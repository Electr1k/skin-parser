<?php

namespace App\Providers;

use App\Repository\Interfaces\LotInterface;
use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\LotRepository\LotRepository;
use App\Repository\SkinSettings\SkinSettingsRepository;
use App\Services\CSData\Interfaces\HasPrices;
use App\Services\CSData\LukexApiHTTPClient;
use Illuminate\Support\ServiceProvider;

class CSDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(HasPrices::class, LukexApiHTTPClient::class);
    }
}
