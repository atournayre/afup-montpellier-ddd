<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Depense\Application\Query\TrouverDepenseQuery;
use App\Depense\Domain\Model\Depense;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\ValueObject\ApiUuid;
use InvalidArgumentException;

/**
 * @implements ProviderInterface<DepenseResource>
 */
final readonly class TrouverDepenseProvider implements ProviderInterface
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?DepenseResource
    {
        if (!isset($uriVariables['uuid']) || !is_string($uriVariables['uuid'])) {
            throw new InvalidArgumentException('UUID manquant ou invalide');
        }

        /** @var Depense|null $depense */
        $depense = $this->queryBus->ask(new TrouverDepenseQuery(
            uuid: ApiUuid::fromString($uriVariables['uuid']),
        ));

        return $depense ? DepenseResource::fromModel($depense) : null;
    }
}
