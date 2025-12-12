<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\ErrorNotification;
use App\Domain\Repository\NotificationRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: ErrorNotification::class)]
class ErrorNotificationHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository
    ) {

    }
    public function __invoke(ErrorNotification $message): void
    {
        $notification = $this->notificationRepository->find($message->getId());
        $notification->markFailed();
        $this->notificationRepository->save($notification);

        throw new \Exception('The notification was not sent!');

    }
}