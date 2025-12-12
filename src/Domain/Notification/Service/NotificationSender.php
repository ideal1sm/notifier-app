<?php

declare(strict_types=1);

namespace App\Domain\Notification\Service;

use App\Domain\Notification\Message\EmailNotification;
use App\Domain\Notification\Message\ErrorNotification;
use App\Domain\Notification\Message\NotificationInterface;
use App\Domain\Notification\Message\PushNotification;
use App\Domain\Notification\Message\SmsNotification;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationSender
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function send(NotificationInterface $notification): void
    {
        $routingKey = match (true) {
            $notification instanceof EmailNotification, $notification instanceof ErrorNotification => 'notification.email',
            $notification instanceof SmsNotification   => 'notification.sms',
            $notification instanceof PushNotification  => 'notification.push',
            default => throw new \InvalidArgumentException('Unknown notification type')
        };

        $this->bus->dispatch($notification, [new AmqpStamp($routingKey)]);
    }
}