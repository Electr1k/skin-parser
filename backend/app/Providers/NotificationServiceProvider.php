<?php

namespace App\Providers;

use App\Services\NotificationSenders\NotificationSenderInterface;
use App\Services\NotificationSenders\TelegramService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationSenderInterface::class, TelegramService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
