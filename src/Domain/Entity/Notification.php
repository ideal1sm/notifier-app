<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\NotificationStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'notifications')]
class Notification
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private readonly int $id;

    #[ORM\ManyToOne(targetEntity: NotificationType::class)]
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id', nullable: false, onDelete: 'RESTRICT')]
    private NotificationType $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $recipient;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subject;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'string', length: 20, enumType: NotificationStatus::class)]
    private NotificationStatus $status;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        NotificationType $type,
        string $recipient,
        string $content,
        NotificationStatus $status = NotificationStatus::PENDING,
        \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        ?string $subject = null

    ) {
        $this->type = $type;
        $this->recipient = $recipient;
        $this->content = $content;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->subject = $subject;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): NotificationType
    {
        return $this->type;
    }

    public function setType(NotificationType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function markSent(): void
    {
        $this->status = NotificationStatus::SENT;
    }

    public function markFailed(): void
    {
        $this->status = NotificationStatus::FAILED;
    }

}