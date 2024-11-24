<?php declare(strict_types=1);

namespace App\Tests\Depense\Domain\Factory;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\Exception\DepenseDansLeFuturException;
use App\Depense\Domain\Exception\DepenseMontantNonPositifException;
use App\Depense\Domain\Factory\DepenseFactory;
use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

final class DepenseFactoryTest extends TestCase
{
    /**
     * @throws DepenseMontantNonPositifException
     */
    public function testCreerUneDepenseDansLeFuturException(): void
    {
        $this->expectException(DepenseDansLeFuturException::class);

        DepenseFactory::creer(
            montant: new DepenseMontant(123),
            description: new DepenseDescription('Date de dépense dans le futur'),
            horodatage: new DepenseHorodatage((new DateTime())->add(new DateInterval('P1D'))),
            categorie: new DepenseCategorie(DepenseCategorieEnum::ALIMENTATION),
        );
    }

    /**
     * @throws DepenseDansLeFuturException
     */
    public function testCreerUneDepenseAvecUnMontantNonPositifException(): void
    {
        $this->expectException(DepenseMontantNonPositifException::class);

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
     * @throws DepenseMontantNonPositifException
     * @throws DepenseDansLeFuturException
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

        $this->assertEquals($depense->montant(), $depenseFactory->montant());
        $this->assertEquals($depense->description(), $depenseFactory->description());
        $this->assertEquals(
            $depense->horodatage()->value->format('Y-m-d\TH:i:s.000\Z'),
            $depenseFactory->horodatage()->value->format('Y-m-d\TH:i:s.000\Z')
        );
        $this->assertEquals($depense->categorie(), $depenseFactory->categorie());
    }
}
