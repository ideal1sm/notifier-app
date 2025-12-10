<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\PushNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: PushNotification::class)]
class PushNotificationHandler
{
    public function __invoke(PushNotification $message): void
    {
        echo sprintf("[PUSH] %s\n", $message->getContent());

        if (rand(1,5) === 1) {
            throw new \Exception("Simulated error for retry");
        }
    }
}