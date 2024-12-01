<?php declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use Countable;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 * @extends IteratorAggregate<TKey, TValue>
 */
interface PaginatorInterface extends IteratorAggregate, Countable
{
    // TODO Pourquoi cette méthode est elle redéfinie et non compatible avec ApiPlatform\State\Pagination\PaginatorInterface ?
    public function getCurrentPage(): int;

    // TODO Pourquoi cette méthode est elle redéfinie et non compatible avec ApiPlatform\State\Pagination\PaginatorInterface ?
    public function getItemsPerPage(): int;

    // TODO Pourquoi cette méthode est elle redéfinie et non compatible avec ApiPlatform\State\Pagination\PaginatorInterface ?
    public function getLastPage(): int;

    // TODO Pourquoi cette méthode est elle redéfinie et non compatible avec ApiPlatform\State\Pagination\PaginatorInterface ?
    public function getTotalItems(): int;
}
