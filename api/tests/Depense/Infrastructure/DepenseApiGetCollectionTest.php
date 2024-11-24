<?php declare(strict_types=1);

namespace App\Tests\Depense\Infrastructure;

use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use App\Tests\Tools\ApiTestCase\CustomApiTestCase;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DepenseApiGetCollectionTest extends CustomApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testGetCollectionAvecBddVideTest(): void
    {
        $this->get('/depenses');
        self::assertResponseIsSuccessful();
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws JsonException
     */
    public function testGetCollectionAvecUnElementEnBdd(): void
    {
        $this->generateDatabaseRecords([
            $depenseLoisir = DepenseInMemory::DepenseLoisir()
        ]);

        $depenses = $this->get('/depenses');
        self::assertResponseIsSuccessful();
        $this->assertCount(1, $depenses->toArray()['hydra:member']);
        $this->assertCollectionResponseContainsEntity($depenses, $depenseLoisir);
    }

    /**
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testGetCollectionAvecTroisElementsEnBdd(): void
    {
        $this->generateDatabaseRecords([
            $depenseLoisir = DepenseInMemory::DepenseLoisir(),
            $depenseLogement = DepenseInMemory::DepenseLogement(),
            $depenseShopping = DepenseInMemory::DepenseShopping()
        ]);

        $depenses = $this->get('/depenses');
        self::assertResponseIsSuccessful();
        $this->assertCount(3, $depenses->toArray()['hydra:member']);
        $this->assertCollectionResponseEqualsEntities($depenses, [
            $depenseLoisir,
            $depenseLogement,
            $depenseShopping
        ]);
    }
}
