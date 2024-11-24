<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Depense\Application\Query\TrouverToutesLesDepensesQuery;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;

final readonly class TrouverToutesLesDepensesProvider implements ProviderInterface
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $depenses = $this->queryBus->ask(new TrouverToutesLesDepensesQuery());

        $depensesResource = [];

        foreach ($depenses as $depense) {
            $depensesResource[] = DepenseResource::fromModel($depense);
        }

        if(!is_null($paginator = $depenses->paginator())) {
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
