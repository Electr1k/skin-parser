<?php

namespace App\Services\NotificationSenders;

interface NotificationSenderInterface
{
    public function sendNotification(string $message): void;
}
