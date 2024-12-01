<?php

declare(strict_types=1);

namespace App\Depense\Application\Query;

use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\Repository\DepenseRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class TrouverDepenseQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DepenseRepositoryInterface $depenseRepository
    )
    {
    }

    // TODO Pourquoi pas un objet de type Depense dans tous les cas (gestion du null) ?
    public function __invoke(TrouverDepenseQuery $query): ?Depense
    {
        return $this->depenseRepository->findByApiUuid($query->uuid);
    }
}
