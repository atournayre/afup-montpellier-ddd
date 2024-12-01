<?php declare(strict_types=1);

namespace App\Tests\Depense\Domain\Factory;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\Exception\DepenseInvalide;
use App\Depense\Domain\Factory\DepenseFactory;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use DateInterval;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DepenseFactoryTest extends TestCase
{
    /**
     * @throws DepenseInvalide
     */
    public function testCreerUneDepenseDansLeFuturException(): void
    {
        $this->expectException(DepenseInvalide::class);

        DepenseFactory::creer(
            montant: new DepenseMontant(123),
            description: new DepenseDescription('Date de dépense dans le futur'),
            horodatage: new DepenseHorodatage((new DateTime())->add(new DateInterval('P1D'))),
            categorie: new DepenseCategorie(DepenseCategorieEnum::ALIMENTATION),
        );
    }

    /**
     * @throws DepenseInvalide
     */
    public function testCreerUneDepenseAvecUnMontantNonPositifException(): void
    {
        $this->expectException(DepenseInvalide::class);

        DepenseFactory::creer(
            montant: new DepenseMontant(0),
            description: new DepenseDescription('Date de dépense dans le futur'),
            horodatage: new DepenseHorodatage(new DateTime()),
            categorie: new DepenseCategorie(DepenseCategorieEnum::ALIMENTATION),
        );

        DepenseFactory::creer(
            montant: new DepenseMontant(-123),
            description: new DepenseDescription('Date de dépense dans le futur'),
            horodatage: new DepenseHorodatage(new DateTime()),
            categorie: new DepenseCategorie(DepenseCategorieEnum::ALIMENTATION),
        );
    }

    /**
     * @throws DepenseInvalide
     */
    public function testCreerUneDepenseAvecDesParametreOk(): void
    {
        $depense = DepenseInMemory::DepenseLogement();

        $depenseFactory = DepenseFactory::creer(
            montant: $depense->montant(),
            description: $depense->description(),
            horodatage: $depense->horodatage(),
            categorie: $depense->categorie()
        );

        $dateHorodatage = $depense->horodatage()->value;
        $dateDepenseFactory = $depenseFactory->horodatage()->value;

        if (!$dateHorodatage instanceof DateTime || !$dateDepenseFactory instanceof DateTime) {
            throw new InvalidArgumentException('Les dates ne peuvent pas être null');
        }

        $this->assertEquals($depense->montant(), $depenseFactory->montant());
        $this->assertEquals($depense->description(), $depenseFactory->description());
        $this->assertEquals($depense->horodatage()->format(), $depenseFactory->horodatage()->format());
        $this->assertEquals($depense->categorie(), $depenseFactory->categorie());
    }
}
