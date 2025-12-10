<?php

declare(strict_types=1);

namespace App\Domain\Notification\Message;

interface NotificationInterface
{
    public function getContent(): string;
}