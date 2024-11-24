<?php

declare(strict_types=1);

namespace App\Depense\Application\Query;

use App\Shared\Application\Query\QueryInterface;

final readonly class TrouverToutesLesDepensesQuery implements QueryInterface
{
    public function __construct(
        public int    $page = 1,
        public int    $size = 30,
    )
    {
    }
}
