<?php declare(strict_types=1);

namespace App\Depense\Domain\Factory;

use App\Depense\Domain\Exception\DepenseInvalide;
use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use DateTime;

final readonly class DepenseFactory
{
    /**
     * @throws DepenseInvalide
     */
    static function creer(
        DepenseMontant     $montant,
        DepenseDescription $description,
        DepenseHorodatage  $horodatage,
        DepenseCategorie   $categorie,
    ): Depense
    {
        if($montant->value <= 0) {
            throw DepenseInvalide::carLeMontantNEstPasPositif();
        }

        if($horodatage->value >= new DateTime()) {
            throw DepenseInvalide::carLaDateEstDansLeFutur();
        }

        return new Depense(
            montant: $montant,
            horodatage: new DepenseHorodatage(new DateTime()),
            description: $description,
            categorie: $categorie,
        );
    }
}