<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Depense\Application\Command\AjouterDepenseCommand;
use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Depense\Infrastructure\ApiPlatform\Resource\DepenseResource;
use App\Shared\Application\Command\CommandBusInterface;
use DateTime;
use Exception;
use InvalidArgumentException;

/**
 * @implements ProcessorInterface<DepenseResource, DepenseResource>
 */
final readonly class AjouterDepenseProcessor implements ProcessorInterface
{
    public function __construct(private CommandBusInterface $commandBus)
    {
    }

    /**
     * @param mixed $data
     * @param Operation $operation
     * @param array<string, string> $uriVariables
     * @param array<string, mixed> $context
     * @return DepenseResource
     * @throws Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): DepenseResource
    {
        if (!$data instanceof DepenseResource) {
            throw new InvalidArgumentException('Les données doivent être une instance de DepenseResource');
        }

        // TODO Pourquoi déléguer la vérification de la donnée au processor ?
        $this->valider($data);

        /** @var Depense $depense */
        $depense = $this->commandBus->dispatch(new AjouterDepenseCommand(
            montant: new DepenseMontant($data->montant),
            description: new DepenseDescription($data->description),
            horodatage: new DepenseHorodatage(new DateTime($data->horodatage)),
            categorie: new DepenseCategorie($data->categorie),
        ));

        return DepenseResource::fromModel($depense);
    }

    private function valider(DepenseResource $data): void
    {
        $erreurs = $data->valider();

        if (empty($erreurs)) {
            return;
        }

        throw new InvalidArgumentException(current($erreurs));
    }
}