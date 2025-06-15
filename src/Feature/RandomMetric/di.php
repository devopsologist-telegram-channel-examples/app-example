<?php

declare(strict_types=1);

namespace App\Feature\RandomMetric;

use App\Feature\RandomMetric\Command\SetRandomMetricHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $di
        ->services()
        ->set(SetRandomMetricHandler::class)->args([
            '$metricsDsn' => '%env(METRICS_DSN)%'
        ])
        ->autoconfigure()
        ->autowire()
    ;
};
