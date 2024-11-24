<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Depense\Application\Query\TrouverDepenseQuery;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\ValueObject\ApiUuid;
use Symfony\Component\Uid\Uuid;

final readonly class TrouverDepenseProvider implements ProviderInterface
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $depense = $this->queryBus->ask(new TrouverDepenseQuery(
            uuid: new ApiUuid(Uuid::fromString($uriVariables['uuid'])),
        ));

        return $depense ? DepenseResource::fromModel($depense) : null;
    }
}
