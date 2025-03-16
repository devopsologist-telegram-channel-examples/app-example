<?php

declare(strict_types=1);

namespace App\Infrastructure\PostgresThesis\ValinorIntegration;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use Thesis\Result\Hydrator;

final readonly class ValinorHydrator implements Hydrator
{
    /**
     * @throws MappingError
     */
    public function hydrate(mixed $data, string $class): object
    {
        if (\is_array($data)) {
            return (new MapperBuilder())
                ->mapper()
                ->map($class, Source::array($data))
            ;
        }

        /** @psalm-suppress MixedMethodCall */
        return new $class($data);
    }
}
