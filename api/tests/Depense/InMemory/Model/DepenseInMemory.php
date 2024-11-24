<?php declare(strict_types=1);

namespace App\Tests\Depense\InMemory\Model;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use DateTime;

final readonly class DepenseInMemory
{
    public static function DepenseLogement(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour le logement'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::LOGEMENT),
        );
    }

    public static function DepenseAlimentation(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour l\'alimentation'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::ALIMENTATION),
        );
    }

    public static function DepenseTransport(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour le transport'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::TRANSPORT),
        );
    }

    public static function DepenseLoisir(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour les loisirs'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::LOISIR),
        );
    }

    public static function DepenseSante(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour la santé'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::SANTE),
        );
    }

    public static function DepenseShopping(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour le shopping'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::SHOPPING),
        );
    }

    public static function DepenseServices(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour les services'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::SERVICES),
        );
    }

    public static function DepenseInvestissement(): Depense
    {
        return new Depense(
            montant: new DepenseMontant(123),
            horodatage: new DepenseHorodatage(new DateTime()),
            description: new DepenseDescription('Une dépense pour l\'investissement'),
            categorie: new DepenseCategorie(DepenseCategorieEnum::INVESTISSEMENT),
        );
    }
}