<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\State;

use ApiPlatform\State\Pagination\PaginatorInterface;
use Exception;
use IteratorAggregate;
use Traversable;

/**
 * @template T of object
 * @implements IteratorAggregate<mixed, T>
 * @implements PaginatorInterface<T>
 */
final readonly class Paginator implements PaginatorInterface, IteratorAggregate
{
    /**
     * @param Traversable<array-key, T> $items
     */
    public function __construct(
        private Traversable $items,
        private float      $currentPage,
        private float      $itemPerPage,
        private float      $lastPage,
        private float      $totalItems,
    )
    {
    }

    /**
     * @return Traversable<array-key, T>
     */
    public function getIterator(): Traversable
    {
        return $this->items;
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function getLastPage(): float
    {
        return $this->lastPage;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->itemPerPage;
    }
}