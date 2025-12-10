<?php

declare(strict_types=1);

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class PushNotificationRequest
{
    public function __construct(
        #[Assert\NotBlank]
        private readonly string $deviceToken,
        #[Assert\NotBlank]
        private readonly string $title,
        #[Assert\NotBlank]
        private readonly string $content
    ) {
    }

    public function getDeviceToken(): string
    {
        return $this->deviceToken;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}