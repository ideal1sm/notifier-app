<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\DTO\SmsNotificationRequest;
use App\Application\Service\ApiResponder;
use App\Application\Service\RequestValidator;
use App\Domain\Entity\Notification;
use App\Domain\Notification\Message\SmsNotification;
use App\Domain\Notification\Service\NotificationSender;
use App\Domain\Repository\NotificationRepository;
use App\Domain\Repository\NotificationTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/notifications/sms', name: 'notifications_sms', methods: ['POST'])]
final class SmsNotificationController
{
    public function __construct(
        private readonly RequestValidator $validator,
        private readonly ApiResponder $responder,
        private readonly NotificationSender $sender,
        private readonly NotificationRepository $notificationRepository,
        private readonly NotificationTypeRepository $notificationTypeRepository
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent() ?: '{}', true);

        $dto = new SmsNotificationRequest(
            $data['phoneNumber'] ?? '',
            $data['content'] ?? '',
            $data['subject'] ?? '',
        );

        if ($errorResponse = $this->validator->validate($dto)) {
            return $errorResponse;
        }

        $type = $this->notificationTypeRepository->findOneByName('sms');
        if (!$type) {
            return $this->responder->error('BAD_REQUEST', 'Notification type not found');
        }

        $notificationEntity = new Notification(
            type: $type,
            recipient: $dto->getPhoneNumber(),
            content: $dto->getContent(),
            subject: $dto->getSubject()
        );

        $this->notificationRepository->save($notificationEntity);

        $notification = new SmsNotification($notificationEntity->getId(), $dto->getPhoneNumber(), $dto->getSubject(), $dto->getContent());

        $this->sender->send($notification);

        return $this->responder->success('Sms notification queued!');
    }

}