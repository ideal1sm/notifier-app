<?php

declare(strict_types=1);

namespace App\Domain\Notification\Handler;

use App\Domain\Notification\Message\EmailNotification;
use App\Domain\Repository\NotificationRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler(handles: EmailNotification::class)]
class EmailNotificationHandler
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
        private readonly ParameterBagInterface $parameterBag,
    ) {

    }
    public function __invoke(EmailNotification $message): void
    {
        $notification = $this->notificationRepository->find($message->getId());

        $email = (new Email())
            ->from($this->parameterBag->get('mail_from'))
            ->to($message->getRecipient())
            ->subject($message->getSubject())
            ->text($message->getContent());

        try {
            $this->mailer->send($email);

            $notification->markSent();
            $this->logger->info('Mail sent!');
        } catch (TransportExceptionInterface $e) {
            $notification->markFailed();
            $this->logger->error($e->getMessage());
        }

        $this->notificationRepository->save($notification);

    }
}