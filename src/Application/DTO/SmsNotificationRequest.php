<?php

declare(strict_types=1);

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class SmsNotificationRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\+?[0-9]{7,15}$/', message: 'Invalid phone number format')]
        private readonly string $phoneNumber,
        #[Assert\NotBlank]
        private readonly string $subject,
        #[Assert\NotBlank]
        #[Assert\Length(max: 480, maxMessage: 'SMS too long')]
        private readonly string $content
    ) {
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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