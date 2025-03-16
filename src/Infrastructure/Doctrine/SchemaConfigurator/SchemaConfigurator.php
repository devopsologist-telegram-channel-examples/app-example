<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\SchemaConfigurator;

use Doctrine\DBAL\Schema\Schema;

final readonly class SchemaConfigurator
{
    public function __construct(
        private Schema $schema,
    ) {
    }

    public function table(string $name): TableConfigurator
    {
        return new TableConfigurator($this->schema->createTable($name));
    }
}
