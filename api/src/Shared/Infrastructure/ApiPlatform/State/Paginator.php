<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\State;

use ApiPlatform\State\Pagination\PaginatorInterface;
use IteratorAggregate;
use Traversable;

final readonly class Paginator implements PaginatorInterface, IteratorAggregate
{
    public function __construct(
        private \Traversable $items,
        private float $currentPage,
        private float $itemPerPage,
        private float $lastPage,
        private float $totalItems,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    /**
     * @inheritDoc
     */
    public function getLastPage(): float
    {
        return $this->lastPage;
    }

    /**
     * @inheritDoc
     */
    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    /**
     * @inheritDoc
     */
    public function getItemsPerPage(): float
    {
        return $this->itemPerPage;
    }
}
