<?php

declare(strict_types=1);

namespace App\Domain\Notification\Message;
class PushNotification implements NotificationInterface
{
    private string $content;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $content)
    {
        $this->content = $content;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}