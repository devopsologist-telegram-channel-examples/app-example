<?php

declare(strict_types=1);

namespace App\Feature\StringFromDb\Query;

use App\Feature\StringFromDb\GetStringFromDb;
use App\Feature\StringFromDb\StringFromDb;
use App\Infrastructure\Doctrine\SchemaConfigurator\SchemaConfigurator;
use App\Infrastructure\Doctrine\SchemaConfigurator\SchemaSubscriber;
use App\Infrastructure\PostgresThesis\PostgresConnection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Thesis\StatementExecutor\StatementExecutionException;

final readonly class GetStringFromDbHandler implements SchemaSubscriber
{
    public function __construct(
        private PostgresConnection $connection,
    ) {
    }

    public function configureSchema(SchemaConfigurator $schema): void
    {
        $schema
            ->table('data')
            ->stringColumn('data')
        ;
    }

    /**
     * @throws StatementExecutionException
     */
    #[AsMessageHandler]
    public function __invoke(GetStringFromDb $query): StringFromDb
    {
        return $this
            ->connection
            ->execute('select data from data')
            ->rowColumn('data')
            ->hydrate(StringFromDb::class)
            ->fetch(static fn(): StringFromDb => new StringFromDb(''))
        ;
    }
}
