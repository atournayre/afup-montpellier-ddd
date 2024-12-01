<?php declare(strict_types=1);

namespace App\Tests\Depense\Infrastructure;

use App\Tests\Depense\InMemory\Model\DepenseInMemory;
use App\Tests\Tools\ApiTestCase\CustomApiTestCase;
use Exception;
use InvalidArgumentException;
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
        $horodatage = $depenseLogement->horodatage()->value;

        if (!$horodatage instanceof \DateTime) {
            throw new InvalidArgumentException('La date de la dépense ne peut pas être null');
        }

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

        /** @var array{montant: int, description: string, horodatage: string, categorie: string} $responseDepense */
        $responseDepense = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('montant', $responseDepense);
        $this->assertArrayHasKey('description', $responseDepense);
        $this->assertArrayHasKey('horodatage', $responseDepense);
        $this->assertArrayHasKey('categorie', $responseDepense);

        $this->assertEquals($responseDepense['montant'], $depenseLogement->montant()->value);
        $this->assertEquals($responseDepense['description'], $depenseLogement->description()->value);
        $this->assertEquals($responseDepense['horodatage'], $depenseLogement->horodatage()->format());
        $this->assertStringContainsString($depenseLogement->categorie()->value->value, $responseDepense['categorie']);
    }
}
