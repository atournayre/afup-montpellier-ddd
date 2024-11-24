<?php

declare(strict_types=1);

namespace App\Depense\Application\Command;

use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Shared\Application\Command\CommandInterface;

final readonly class AjouterDepenseCommand implements CommandInterface
{
    public function __construct(
        public DepenseMontant     $montant,
        public DepenseDescription $description,
        public DepenseHorodatage  $horodatage,
        public DepenseCategorie   $categorie,
    )
    {
    }
}
