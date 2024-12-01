<?php

declare(strict_types=1);

namespace App\Depense\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class TrouverToutesLesDepensesQuery implements QueryInterface
{
    public function __construct(
        // TODO Pourquoi ne pas affecter la valeur par défaut ?
        public int    $page = 1,
        // TODO Pourquoi ne pas affecter la valeur par défaut ?
        public int    $size = 10,
    )
    {
    }
}
