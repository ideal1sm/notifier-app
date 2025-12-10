<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\EmailNotification;
use App\Domain\Repository\NotificationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: EmailNotification::class)]
class EmailNotificationHandler
{
    public function __construct(
        private readonly NotificationRepository $repository,
        private readonly MailerInterface $mailer
    ) {

    }
    public function __invoke(EmailNotification $message): void
    {
        echo sprintf("[EMAIL] %s - %s\n", $message->getSubject(), $message->getContent());

        if (rand(1,5) === 1) {
            throw new \Exception("Simulated error for retry");
        }
    }
}