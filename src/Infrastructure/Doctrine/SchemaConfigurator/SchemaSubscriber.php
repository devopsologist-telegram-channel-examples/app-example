<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\SchemaConfigurator;

interface SchemaSubscriber
{
    public function configureSchema(SchemaConfigurator $schema): void;
}
