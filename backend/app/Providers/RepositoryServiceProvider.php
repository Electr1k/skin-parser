<?php

namespace App\Providers;

use App\Repository\Interfaces\LotInterface;
use App\Repository\Interfaces\SkinSettingsInterface;
use App\Repository\LotRepository;
use App\Repository\SkinSettingsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(SkinSettingsInterface::class, SkinSettingsRepository::class);
        $this->app->bind(LotInterface::class, LotRepository::class);
    }
}
