<?php

declare(strict_types=1);

namespace App\Depense\Application\Query;

use App\Depense\Domain\Repository\DepenseRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class TrouverToutesLesDepensesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepenseRepositoryInterface $depenseRepository,
    )
    {
    }

    public function __invoke(TrouverToutesLesDepensesQuery $query): DepenseRepositoryInterface
    {
        if(!is_null($query->page) && !is_null($query->size)) {
            return $this->depenseRepository->findAll()->withPagination(page: $query->page, itemsPerPage: $query->size);
        }

        return $this->depenseRepository->findAll();
    }
}
