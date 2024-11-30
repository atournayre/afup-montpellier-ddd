<?php declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends IteratorAggregate<TKey, TValue>
 */
interface RepositoryInterface extends IteratorAggregate, Countable
{
    /**
     * @return Iterator<TKey, TValue>
     */
    public function getIterator(): Iterator;

    public function count(): int;

    /**
     * @return PaginatorInterface<TKey, TValue>|null
     */
    public function paginator(): ?PaginatorInterface;

    public function withPagination(int $page, int $itemsPerPage): static;

    public function withoutPagination(): static;
}
