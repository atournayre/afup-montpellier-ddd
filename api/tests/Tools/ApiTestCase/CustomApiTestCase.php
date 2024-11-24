<?php declare(strict_types = 1);

namespace App\Tests\Tools\ApiTestCase;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CustomApiTestCase extends ApiTestCase
{
    public function generateDatabaseRecords(array $entities): void
    {
        $em = self::getContainer()->get(EntityManagerInterface::class);
        foreach ($entities as $entity) {
            $em->persist($entity);
        }

        $em->flush();
    }

    /**
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
        return json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR)['hydra:description'];
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
     * @param object $entity
     * @return void
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function assertCollectionResponseContainsEntity(ResponseInterface $response, object $entity): void
    {
        try {
            $entityList = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR)['hydra:member'];

            $entityUuids = array_map(static function($item) {
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
     * @param ResponseInterface $response
     * @param array $entities
     * @return void
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function assertCollectionResponseEqualsEntities(ResponseInterface $response, array $entities): void
    {
        try {
            $entityList = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR)['hydra:member'];

            $responseUuids = array_map(static function($item) {
                return self::getUuidByIri($item['@id']);
            }, $entityList);

            $expectedUuids = array_map(static function($entity) {
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