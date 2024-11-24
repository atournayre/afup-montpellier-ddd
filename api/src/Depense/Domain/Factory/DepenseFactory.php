<?php declare(strict_types=1);

namespace App\Depense\Domain\Factory;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\Exception\DepenseDansLeFuturException;
use App\Depense\Domain\Exception\DepenseMontantNonPositifException;
use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use DateTime;

final readonly class DepenseFactory
{
    /**
     * @throws DepenseMontantNonPositifException
     * @throws DepenseDansLeFuturException
     */
    static function creer(
        DepenseMontant     $montant,
        DepenseDescription $description,
        DepenseHorodatage  $horodatage,
        DepenseCategorie   $categorie,
    ): Depense
    {
        if($montant->value <= 0) {
            throw new DepenseMontantNonPositifException();
        }

        if($horodatage->value >= new DateTime()) {
            throw new DepenseDansLeFuturException();
        }

        return new Depense(
            montant: $montant,
            horodatage: new DepenseHorodatage(new DateTime()),
            description: $description,
            categorie: $categorie,
        );
    }
}