<?php

declare(strict_types=1);

namespace App\Depense\Application\Command;

use App\Depense\Domain\Exception\DepenseInvalide;
use App\Depense\Domain\Factory\DepenseFactory;
use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\Repository\DepenseRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class AjouterDepenseCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DepenseRepositoryInterface $depenseRepository,
    )
    {
    }

    /**
     * @throws DepenseInvalide
     */
    public function __invoke(AjouterDepenseCommand $command): Depense
    {
        $depense = DepenseFactory::creer(
            montant: $command->montant,
            description: $command->description,
            horodatage: $command->horodatage,
            categorie: $command->categorie
        );

        $this->depenseRepository->save($depense);

        return $depense;
    }
}
