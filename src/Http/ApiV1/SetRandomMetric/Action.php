<?php

declare(strict_types=1);

namespace App\Http\ApiV1\SetRandomMetric;

use App\Feature\RandomMetric\SetRandomMetric;
use App\Infrastructure\MessageBus\Symfony\MessageBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class Action
{
    #[Route(path: '/set-random-metric', methods: ['POST'])]
    public function __invoke(MessageBus $messageBus): JsonResponse
    {
        $messageBus->execute(new SetRandomMetric());

        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
