<?php

declare(strict_types=1);

namespace App\Feature\RandomMetric\Command;

use App\Feature\RandomMetric\SetRandomMetric;
use Random\RandomException;
use Spiral\Goridge\RPC\RPC;
use Spiral\RoadRunner\Metrics\Metrics;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

final readonly class SetRandomMetricHandler
{
    public function __construct(
        public string $metricsDsn,
    ) {
    }

    /**
     * @throws RandomException
     */
    #[AsMessageHandler]
    public function __invoke(SetRandomMetric $query): void
    {
        $metrics = new Metrics(RPC::create($this->metricsDsn));

        $metrics->set('random_metric', \random_int(1, 100));
    }
}
