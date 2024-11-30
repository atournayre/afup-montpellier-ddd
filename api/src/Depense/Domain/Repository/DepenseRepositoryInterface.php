<?php declare(strict_types=1);

namespace App\Depense\Domain\Repository;

use App\Depense\Domain\Model\Depense;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Shared\Domain\ValueObject\ApiUuid;

/**
 * @extends RepositoryInterface<int, Depense>
 */
interface DepenseRepositoryInterface extends RepositoryInterface
{
    public function save(Depense $depense): void;

    public function findByApiUuid(ApiUuid $apiUuid): ?Depense;

    public function findAll(): static;
}
