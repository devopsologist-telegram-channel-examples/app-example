<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use App\Infrastructure\Doctrine\Console\SchemaValidateCommand;
use App\Infrastructure\Doctrine\SchemaConfigurator\ConfigurableSchemaProvider;
use App\Infrastructure\Doctrine\SchemaConfigurator\SchemaSubscriber;
use App\Infrastructure\Doctrine\SchemaConfigurator\SchemaSubscriberChain;
use Doctrine\Migrations\Provider\SchemaProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\inline_service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $di, ContainerBuilder $builder): void {
    $di->extension('doctrine_migrations', [
        'services' => [
            SchemaProvider::class => ConfigurableSchemaProvider::class,
        ],
    ]);

    $builder->registerForAutoconfiguration(SchemaSubscriber::class)->addTag(SchemaSubscriber::class);

    $services = $di->services();

    $services
        ->set(SchemaProvider::class)->factory([service('doctrine.migrations.dependency_factory'), 'getSchemaProvider'])
        ->set(ConfigurableSchemaProvider::class)->args([
            '$subscriber' => inline_service(SchemaSubscriberChain::class)->args([
                '$subscribers' => tagged_iterator(SchemaSubscriber::class),
            ]),
        ])
        ->autoconfigure()
        ->autowire()
        ->set(SchemaValidateCommand::class)->args([
            '$configuration' => service('doctrine.migrations.configuration'),
        ])
        ->autoconfigure()
        ->autowire()
    ;
};
