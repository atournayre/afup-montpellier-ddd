<?php declare(strict_types = 1);

namespace App\Tests\Tools\ApiTestCase;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Shared\Domain\Model\BaseEntity;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CustomApiTestCase extends ApiTestCase
{
    /**
     * @param array<int, object> $entities
     */
    public function generateDatabaseRecords(array $entities): void
    {
        /** @var EntityManagerInterface $em */
        $em = self::getContainer()->get(EntityManagerInterface::class);
        foreach ($entities as $entity) {
            $em->persist($entity);
        }

        $em->flush();
    }

    /**
     * @param array<string, string|array<string, string>>|null $filters
     * @throws TransportExceptionInterface
     */
    public function get(string $url, ?string $token = null, ?string $accept = null, ?array $filters = null): ResponseInterface
    {
        $headers = [];

        if (!is_null($token)) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        if (!is_null($accept)) {
            $headers['Accept'] = $accept;
        }

        return self::createClient()->request(
            'GET',
            $url,
            [
                'headers' => $headers,
                'query' => $filters,
            ]
        );
    }

    /**
     * @param array<string, mixed> $json
     * @throws TransportExceptionInterface
     */
    public function post(string $url, array $json, ?string $token = null): ResponseInterface
    {
        $client = self::createClient();

        $headers = [
            'Content-Type' => 'application/ld+json',
            'Accept' => 'application/ld+json',
        ];

        if (!is_null($token)) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $json
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function getDescriptionByResponse(ResponseInterface $response): string
    {
        /** @var array{'hydra:description': string} $data */
        $data = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);

        /** @var string */
        return $data['hydra:description'];
    }

    /**
     * @param string $iri
     * @return string
     */
    public static function getUuidByIri(string $iri): string
    {
        $explodeUrl = explode("/", ($iri));
        return end($explodeUrl);
    }

    /**
     * @param ResponseInterface $response
     * @param BaseEntity $entity
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function assertCollectionResponseContainsEntity(ResponseInterface $response, BaseEntity $entity): void
    {
        try {
            /** @var array{'hydra:member': array<int, array{'@id': string}>} $data */
            $data = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);
            $entityList = $data['hydra:member'];

            $entityUuids = array_map(static function(array $item): string {
                return self::getUuidByIri($item['@id']);
            }, $entityList);

            $this->assertContains(
                $entity->uuid()->value->toRfc4122(),
                $entityUuids,
                sprintf("L'entité avec l'UUID %s n'a pas été trouvée dans la collection de réponse.", $entity->uuid())
            );
        } catch (Exception $e) {
            $this->fail(sprintf(
                "Erreur lors de la vérification de la présence d'entité dans une collection : %s",
                $e->getMessage(),
            ));
        }
    }

    /**
     * @param array<int, BaseEntity> $entities
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function assertCollectionResponseEqualsEntities(ResponseInterface $response, array $entities): void
    {
        try {
            /** @var array{'hydra:member': array<int, array{'@id': string}>} $data */
            $data = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);
            $entityList = $data['hydra:member'];

            $responseUuids = array_map(static function(array $item): string {
                return self::getUuidByIri($item['@id']);
            }, $entityList);

            $expectedUuids = array_map(static function(BaseEntity $entity): string {
                return $entity->uuid()->value->toRfc4122();
            }, $entities);

            $this->assertEqualsCanonicalizing(
                $expectedUuids,
                $responseUuids,
                "La collection dans la réponse ne contient pas exactement les entités attendues."
            );
        } catch (Exception $e) {
            $this->fail(sprintf(
                "Erreur lors de la vérification stricte de la collection d'entités : %s",
                $e->getMessage(),
            ));
        }
    }
}