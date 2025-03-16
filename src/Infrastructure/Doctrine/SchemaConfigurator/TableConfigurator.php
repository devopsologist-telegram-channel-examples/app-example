<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\SchemaConfigurator;

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;

final readonly class TableConfigurator
{
    public function __construct(
        private Table $table,
    ) {
    }

    /**
     * @no-named-arguments
     */
    public function primaryKey(string $column, string ...$columns): self
    {
        $this->table->setPrimaryKey([$column, ...$columns]);

        return $this;
    }

    /**
     * @no-named-arguments
     */
    public function index(string $column, string ...$columns): self
    {
        $this->table->addIndex([$column, ...$columns]);

        return $this;
    }

    /**
     * @no-named-arguments
     */
    public function uniqueIndex(string $column, string ...$columns): self
    {
        $this->table->addUniqueIndex([$column, ...$columns]);

        return $this;
    }

    public function smallIntColumn(string $name, bool $nullable = false, ?int $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::SMALLINT)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function intColumn(string $name, bool $nullable = false, bool $unsigned = false, ?int $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::INTEGER)
            ->setUnsigned($unsigned)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    /**
     * @param ?numeric-string $default
     */
    public function bigintColumn(string $name, bool $nullable = false, ?string $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::BIGINT)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function decimalColumn(string $name, int $precision = 10, int $scale = 5, bool $nullable = false, ?int $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::DECIMAL)
            ->setPrecision($precision)
            ->setScale($scale)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function floatColumn(string $name, bool $nullable = false, ?int $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::FLOAT)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function stringColumn(string $name, bool $nullable = false, ?string $default = null, ?int $length = null, bool $fixed = false): self
    {
        $this
            ->table
            ->addColumn($name, Types::STRING)
            ->setNotnull(!$nullable)
            ->setLength($length)
            ->setDefault($default)
            ->setFixed($fixed)
        ;

        return $this;
    }

    public function textColumn(string $name, bool $nullable = false, ?string $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::TEXT)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function boolColumn(string $name, bool $nullable = false, ?bool $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::BOOLEAN)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function uuidColumn(string $name, bool $nullable = false, ?string $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::GUID)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function jsonColumn(string $name, bool $nullable = false, mixed $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::JSON)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function jsonbColumn(string $name, bool $nullable = false, mixed $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::JSON)
            ->setNotnull(!$nullable)
            ->setPlatformOption('jsonb', true)
            ->setDefault($default)
        ;

        return $this;
    }

    public function dateTimeColumn(string $name, bool $nullable = false, mixed $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::DATETIMETZ_IMMUTABLE)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }

    public function dateColumn(string $name, bool $nullable = false, mixed $default = null): self
    {
        $this
            ->table
            ->addColumn($name, Types::DATE_IMMUTABLE)
            ->setNotnull(!$nullable)
            ->setDefault($default)
        ;

        return $this;
    }
}
