<?php

declare(strict_types=1);

namespace App\Application\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiResponder
{
    public function success(string $message = '', array $data = []): JsonResponse

    {
        return new JsonResponse([
            'code' => 'SUCCESS',
            'data' => $data,
            'errors' => [],
            'message' => $message
        ], Response::HTTP_ACCEPTED);
    }
    public function error(string $code, string $message, array $errors = [], int $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse([
            'code' => $code,
            'errors' => $errors,
            'message' => $message
        ], $status);
    }
}