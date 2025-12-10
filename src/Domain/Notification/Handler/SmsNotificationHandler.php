<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\SmsNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: SmsNotification::class)]
class SmsNotificationHandler
{
    public function __invoke(SmsNotification $message): void
    {
        echo sprintf("[SMS] %s\n", $message->getContent());

        if (rand(1, 5) === 1) {
            throw new \Exception("Simulated error for retry");
        }
    }
}