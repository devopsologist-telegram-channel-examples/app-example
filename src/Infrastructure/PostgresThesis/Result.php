<?php

declare(strict_types=1);

namespace App\Infrastructure\PostgresThesis;

use Thesis\Result\Result as ThesisResult;

/**
 * @template TKey
 * @template TRow
 * @implements \IteratorAggregate<TKey, TRow>
 */
final readonly class Result implements \IteratorAggregate
{
    /**
     * @param ThesisResult<TKey, TRow> $result
     */
    private function __construct(
        private ThesisResult $result,
    ) {
    }

    /**
     * @template TResultKey
     * @template TResultRow
     * @param ThesisResult<TResultKey, TResultRow> $result
     * @return self<TResultKey, TResultRow>
     */
    public static function fromThesisResult(ThesisResult $result): self
    {
        return new self($result);
    }

    /**
     * @template TNewKey
     * @param callable(TRow): TNewKey $mapper
     * @return self<TNewKey, TRow>
     */
    public function mapKey(callable $mapper): self
    {
        return new self($this->result->mapKey($mapper));
    }

    /**
     * @template TNewRow
     * @param callable(TRow): TNewRow $mapper
     * @return self<TKey, TNewRow>
     */
    public function mapRow(callable $mapper): self
    {
        return new self($this->result->mapRow($mapper));
    }

    /**
     * @return self<mixed, TRow>
     * @throws \UnexpectedValueException If row value is not of type array{$column: mixed}
     */
    public function keyColumn(int|string $column): self
    {
        return new self($this->result->keyColumn($column));
    }

    /**
     * @return self<TKey, mixed>
     * @throws \UnexpectedValueException If row value is not of type array{$column: mixed}
     */
    public function rowColumn(int|string $column): self
    {
        return new self($this->result->rowColumn($column));
    }

    /**
     * @template TNewRow of object
     * @param class-string<TNewRow> $class
     * @return self<TKey, TNewRow>
     */
    public function hydrate(string $class): self
    {
        return new self($this->result->hydrate($class));
    }

    /**
     * @return (TKey is int|string ? array<TKey, TRow> : array<TRow>)
     * @throws \TypeError If result key is not of type ?scalar
     */
    public function toArray(): array
    {
        return $this->result->toArray();
    }

    /**
     * @return list<TRow>
     */
    public function toList(): array
    {
        return $this->result->toList();
    }

    /**
     * @template TDefault
     * @template TCallable of ?callable(): TDefault
     * @param TCallable $default
     * @return (TCallable is null ? TRow|null : TRow|TDefault)
     */
    public function fetch(?callable $default = null): mixed
    {
        return $this->result->fetch($default);
    }

    /**
     * @return \Iterator<TKey, TRow>
     */
    #[\Override]
    public function getIterator(): \Iterator
    {
        return $this->result->getIterator();
    }
}
