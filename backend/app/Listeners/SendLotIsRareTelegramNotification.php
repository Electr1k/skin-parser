<?php

namespace App\Listeners;

use App\Events\LotIsRare;
use App\Models\Keychain;
use App\Models\Lot;
use App\Models\Sticker;
use App\Services\NotificationSenders\NotificationSenderInterface;

readonly class SendLotIsRareTelegramNotification // implements ShouldQueue
{

    public function __construct(private NotificationSenderInterface $notificationSender){}

    public function handle(LotIsRare $event): void
    {
        $message = $this->makeMessage($event->lot->load(['skinSettings', 'skinSettings.price']));

        $this->notificationSender->sendNotification($message);
    }


    private function makeMessage(Lot $lot): string
    {
        $link = "https://steamcommunity.com/market/listings/730/{$lot->skinSettings->uri}#buylisting|{$lot->m}|730|2|{$lot->a}";

        $defaultPrice = $lot->skinSettings->price->price;
        return sprintf(
            "🚨 Обнаружен редкий float!\n".
            "Предмет: %s\n".
            "Float: <b>%s</b>\n\n".
            "Цена стикеров: $<b>%s</b>\n".
            "Стикеры: \n%s\n\n".
            "Цена брелков: $<b>%s</b>\n".
            "Брелки: \n%s\n\n".
            "Цена: %s\n".
            "Дефолтная цена: %s\n".
            "URL: <a href='%s'>Страница: %s</a>",
            $lot->skinSettings->name,
            $lot->float,
            $lot->stickersPrice(),
            $lot->stickerModels()->sortBy('slot')->map(static fn(Sticker $sticker) => "$sticker->name ($" . $sticker->price?->last_24h . ")")->implode("\n"),
            $lot->keychainsPrice(),
            $lot->keychainsModels()->map(static fn(Keychain $keychain) => "$keychain->name ($" . $keychain->price?->last_24h . ")")->implode("\n"),
            $lot->price_dirty,
            "$$defaultPrice = " . $defaultPrice*80 . " руб.",
            $link,
            $lot->page
        );
    }
}
