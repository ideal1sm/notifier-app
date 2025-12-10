<?php

declare (strict_types=1);

namespace App\Application\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    public function validate(object $dto): ?JsonResponse
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) === 0) {
            return null;
        }

        $payload = [];
        foreach ($errors as $violation) {
            $payload[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return new JsonResponse(
            ['code' => 'VALIDATION_ERROR', 'errors' => $payload, 'message' => 'Validation failed'],
            Response::HTTP_BAD_REQUEST
        );
    }
}