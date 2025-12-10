<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\DTO\SmsNotificationRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/notifications/sms', name: 'notifications_sms', methods: ['POST'])]
final class SmsNotificationController
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent() ?: '{}', true);

        $dto = new SmsNotificationRequest(
            $data['recipient'] ?? '',
            $data['content'] ?? ''
        );

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->validationErrorResponse($errors);
        }

        // TODO: dispatch command or call Sender

        return new JsonResponse(['status' => 'queued'], Response::HTTP_ACCEPTED);
    }

    private function validationErrorResponse($errors): JsonResponse
    {
        $payload = [];

        foreach ($errors as $violation) {
            $payload[] = [
                'property' => $violation->getPropertyPath(),
                'message'  => $violation->getMessage(),
            ];
        }

        return new JsonResponse(['errors' => $payload], Response::HTTP_BAD_REQUEST);
    }
}