<?php declare(strict_types=1);

namespace App\Tests\Depense\Infrastructure;

use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use App\Tests\Tools\ApiTestCase\CustomApiTestCase;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DepenseApiGetItemTest extends CustomApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testEndpointGetItemDepensesExisteEtPasDeDepense(): void
    {
        $this->get(
            url: sprintf('/depenses/%s', Uuid::v4()),
        );

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws JsonException
     * @throws Exception
     */
    public function testEndpointGetItemDepenses(): void
    {
        $depenseLogement = DepenseInMemory::DepenseLogement();

        $this->generateDatabaseRecords([
            DepenseInMemory::DepenseLoisir(),
            DepenseInMemory::DepenseAlimentation(),
            $depenseLogement,
            DepenseInMemory::DepenseServices(),
            DepenseInMemory::DepenseTransport(),
        ]);

        $response = $this->get(
            url: sprintf('/depenses/%s', $depenseLogement->uuid()->value->toRfc4122()),
        );

        self::assertResponseStatusCodeSame(Response::HTTP_OK);

        $responseDepense = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);

        $this->assertEquals($responseDepense['montant'], $depenseLogement->montant()->value);
        $this->assertEquals($responseDepense['description'], $depenseLogement->description()->value);
        $this->assertEquals($responseDepense['horodatage'], $depenseLogement->horodatage()->value->format('Y-m-d\TH:i:s.000\Z'));
        $this->assertStringContainsString($depenseLogement->categorie()->value->value, $responseDepense['categorie']);
    }
}
