<?php declare(strict_types=1);

namespace App\Tests\Depense\Domain\Model;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use PHPUnit\Framework\TestCase;

final class DepenseCategorieTest extends TestCase
{
    public function testEstDeTypeLogement(): void {
        $depense = DepenseInMemory::DepenseLogement();
        $this->assertEquals(DepenseCategorieEnum::LOGEMENT, $depense->categorie()->value);
    }

    public function testEstDeTypeAlimentation(): void
    {
        $depense = DepenseInMemory::DepenseAlimentation();
        $this->assertEquals(DepenseCategorieEnum::ALIMENTATION, $depense->categorie()->value);
    }

    public function testEstDeTypeTransport(): void
    {
        $depense = DepenseInMemory::DepenseTransport();
        $this->assertEquals(DepenseCategorieEnum::TRANSPORT, $depense->categorie()->value);
    }

    public function testEstDeTypeLoisir(): void
    {
        $depense = DepenseInMemory::DepenseLoisir();
        $this->assertEquals(DepenseCategorieEnum::LOISIR, $depense->categorie()->value);
    }

    public function testEstDeTypeSante(): void
    {
        $depense = DepenseInMemory::DepenseSante();
        $this->assertEquals(DepenseCategorieEnum::SANTE, $depense->categorie()->value);
    }

    public function testEstDeTypeShopping(): void
    {
        $depense = DepenseInMemory::DepenseShopping();
        $this->assertEquals(DepenseCategorieEnum::SHOPPING, $depense->categorie()->value);
    }

    public function testEstDeTypeServices(): void
    {
        $depense = DepenseInMemory::DepenseServices();
        $this->assertEquals(DepenseCategorieEnum::SERVICES, $depense->categorie()->value);
    }

    public function testEstDeTypeInvestissement(): void
    {
        $depense = DepenseInMemory::DepenseInvestissement();
        $this->assertEquals(DepenseCategorieEnum::INVESTISSEMENT, $depense->categorie()->value);
    }
}