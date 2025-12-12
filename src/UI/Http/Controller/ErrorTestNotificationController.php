<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\DTO\EmailNotificationRequest;
use App\Application\Service\ApiResponder;
use App\Application\Service\RequestValidator;
use App\Domain\Entity\Notification;
use App\Domain\Notification\Message\EmailNotification;
use App\Domain\Notification\Message\ErrorNotification;
use App\Domain\Notification\Service\NotificationSender;
use App\Domain\Repository\NotificationRepository;
use App\Domain\Repository\NotificationTypeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/notifications/error', name: 'notifications.error', methods: ['POST'])]
final class ErrorTestNotificationController
{
    public function __construct(
        private readonly ApiResponder $responder,
        private readonly NotificationSender $sender,
        private readonly NotificationRepository $notificationRepository,
        private readonly NotificationTypeRepository $notificationTypeRepository
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $type = $this->notificationTypeRepository->findOneByName('email');

        if (!$type) {
            return $this->responder->error('BAD_REQUEST', 'Notification type not found');
        }

        $notificationEntity = new Notification(
            type: $type,
            recipient: 'test-error',
            content: 'test-error',
            subject: 'test-error'
        );

        $this->notificationRepository->save($notificationEntity);

        $notification = new ErrorNotification($notificationEntity->getId());

        $this->sender->send($notification);

        return $this->responder->success('Error test notification queued!');
    }
}