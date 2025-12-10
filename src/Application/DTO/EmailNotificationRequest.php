<?php

declare(strict_types=1);

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class EmailNotificationRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        private readonly string $recipient,
        #[Assert\NotBlank]
        private readonly string $subject,
        #[Assert\NotBlank]
        private readonly string $content
    ) {
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}