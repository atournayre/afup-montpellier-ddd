<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Depense\Application\Command\AjouterDepenseCommand;
use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Command\CommandBusInterface;
use DateMalformedStringException;
use DateTime;

final readonly class AjouterDepenseProcessor implements ProcessorInterface
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): DepenseResource
    {
        $depense = $this->commandBus->dispatch(new AjouterDepenseCommand(
            montant: new DepenseMontant($data->montant),
            description: new DepenseDescription($data->description),
            horodatage: new DepenseHorodatage(new DateTime($data->horodatage)),
            categorie: new DepenseCategorie(
                DepenseCategorieEnum::tryFrom($data->categorie->value)
            ),
        ));

        return DepenseResource::fromModel($depense);
    }
}
