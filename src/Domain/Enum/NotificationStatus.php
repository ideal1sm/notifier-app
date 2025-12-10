<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum NotificationStatus: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
}
