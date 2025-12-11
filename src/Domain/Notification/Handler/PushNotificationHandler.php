<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\PushNotification;
use App\Domain\Repository\NotificationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: PushNotification::class)]
class PushNotificationHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(PushNotification $message): void
    {
        $notification = $this->notificationRepository->find($message->getId());


        $notification->markSent();
        $this->logger->info('Push notification sent!');
        $this->notificationRepository->save($notification);
    }
}