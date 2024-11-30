<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Depense\Application\Query\TrouverToutesLesDepensesQuery;
use App\Depense\Domain\Model\Depense;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;
use InvalidArgumentException;

/**
 * @implements ProviderInterface<DepenseResource>
 */
final readonly class TrouverToutesLesDepensesProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination $pagination,
    )
    {
    }

    /**
     * @return Paginator<DepenseResource>|array<int, DepenseResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Paginator|array
    {
        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        /** @var RepositoryInterface<int, Depense> $depenses */
        $depenses = $this->queryBus->ask(new TrouverToutesLesDepensesQuery($offset, $limit));

        $depensesResource = [];

        foreach ($depenses as $depense) {
            $depensesResource[] = DepenseResource::fromModel($depense);
        }

        if (!is_null($paginator = $depenses->paginator())) {
            $depensesResource = new Paginator(
                items: new \ArrayIterator($depensesResource),
                currentPage: (float) $paginator->getCurrentPage(),
                itemPerPage: (float) $paginator->getItemsPerPage(),
                lastPage: (float) $paginator->getLastPage(),
                totalItems: (float) $paginator->getTotalItems(),
            );
        }

        return $depensesResource;
    }
}
