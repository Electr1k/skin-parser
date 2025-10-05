<?php

namespace App\Listeners;

use App\Events\LotIsRare;
use App\Models\Lot;
use App\Models\Sticker;
use App\Services\NotificationSenders\NotificationSenderInterface;

readonly class SendLotIsRareTelegramNotification // implements ShouldQueue
{

    public function __construct(private NotificationSenderInterface $notificationSender){}

    public function handle(LotIsRare $event): void
    {
        $message = $this->makeMessage($event->lot->load('skinSettings'));

        $this->notificationSender->sendNotification($message);
    }


    private function makeMessage(Lot $lot): string
    {
        $link = "https://steamcommunity.com/market/listings/730/{$lot->skinSettings->id}#buylisting|{$lot->m}|730|2|{$lot->a}";

        return sprintf(
            "🚨 Обнаружен редкий float!\n".
            "Предмет: %s\n".
            "Float: <b>%s</b>\n\n".
            "Цена стикеров: <b>%s</b>\n".
            "Стикеры: %s\n\n".
            "Цена: %s\n".
            "URL: <a href='%s'>Страница: %s</a>",
            $lot->skinSettings->market_name,
            $lot->float,
            $lot->getStickersPrice(),
            $lot->stickerModels()->sortBy('slot')->map(fn(Sticker $sticker) => "$sticker->name ($" . $sticker->price?->last_24h . ")")->implode("\n"),
            $lot->price_dirty,
            $link,
            $lot->page
        );
    }
}
