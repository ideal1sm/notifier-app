<?php

declare(strict_types=1);

namespace App\Domain\Notification\Message;

class ErrorNotification implements NotificationInterface
{
    public function __construct(
        private int $id,
        private \DateTimeImmutable $createdAt = new \DateTimeImmutable()
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getContent(): string
    {
        return 'error';
    }
}