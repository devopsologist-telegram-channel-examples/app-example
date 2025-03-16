<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\SchemaConfigurator;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\Provider\SchemaProvider;

final readonly class ConfigurableSchemaProvider implements SchemaProvider
{
    public function __construct(
        private SchemaProvider $provider,
        private SchemaSubscriber $subscriber,
    ) {
    }

    public function createSchema(): Schema
    {
        $schema = $this->provider->createSchema();
        $configurator = new SchemaConfigurator($schema);
        $this->subscriber->configureSchema($configurator);

        return $schema;
    }
}
