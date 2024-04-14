<?php

declare(strict_types=1);

use Baldinof\RoadRunnerBundle\BaldinofRoadRunnerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;

return [
    FrameworkBundle::class => ['all' => true],
    MonologBundle::class => ['all' => true],
    BaldinofRoadRunnerBundle::class => ['all' => true],
];
