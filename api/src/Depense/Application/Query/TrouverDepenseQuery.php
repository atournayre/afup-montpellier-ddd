<?php

declare(strict_types=1);

namespace App\Depense\Application\Query;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Domain\ValueObject\ApiUuid;

final readonly class TrouverDepenseQuery implements QueryInterface
{
    public function __construct(
        public ApiUuid $uuid,
    )
    {
    }
}
