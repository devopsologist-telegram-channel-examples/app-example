<?php

declare(strict_types=1);

namespace App\Http\ApiV1\GetStringFromDb;

use App\Feature\StringFromDb\GetStringFromDb;
use App\Infrastructure\MessageBus\Symfony\MessageBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Action
{
    #[Route(path: '/get-string-from-db', methods: ['GET'])]
    public function __invoke(MessageBus $messageBus): JsonResponse
    {
        $stringFromDb = $messageBus->execute(new GetStringFromDb());

        return new JsonResponse([
            'data' => $stringFromDb->string,
        ]);
    }
}
