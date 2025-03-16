<?php

declare(strict_types=1);

namespace App\Feature\StringFromDb;

use App\Feature\StringFromDb\Query\GetStringFromDbHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $di): void {
    $di
        ->services()
        ->set(GetStringFromDbHandler::class)
        ->autoconfigure()
        ->autowire()
    ;
};
