<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\SmsNotification;
use App\Domain\Repository\NotificationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: SmsNotification::class)]
class SmsNotificationHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(SmsNotification $message): void
    {
        $notification = $this->notificationRepository->find($message->getId());


        $notification->markSent();
        $this->logger->info('Sms notification sent!');
        $this->notificationRepository->save($notification);
    }
}