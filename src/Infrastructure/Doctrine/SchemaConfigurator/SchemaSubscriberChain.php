<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\SchemaConfigurator;

final readonly class SchemaSubscriberChain implements SchemaSubscriber
{
    /**
     * @param iterable<SchemaSubscriber> $subscribers
     */
    public function __construct(
        private iterable $subscribers = [],
    ) {
    }

    public function configureSchema(SchemaConfigurator $schema): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->configureSchema($schema);
        }
    }
}
