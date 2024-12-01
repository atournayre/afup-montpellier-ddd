<?php declare(strict_types=1);

namespace App\Tests\Depense\Infrastructure;

use App\Tests\Tools\ApiTestCase\CustomApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DepenseApiPostTest extends CustomApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testEndPointPostExiste(): void
    {
        $this->post(
            url: '/depenses',
            json: [
                'montant' => '',
                'horodatage' => '',
                'description' => '',
                'categorie' => ''
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function testEndPointPostCreationDansFuturException(): void
    {
        $response = $this->post(
            url: '/depenses',
            json: [
                'montant' => 5000,
                'horodatage' => '2025-11-19T19:30:00.000Z',
                'description' => 'Déplacement sur Montpellier pour l\'AFUP',
                'categorie' => '/enums/depenses/categorie/TRANSPORT'
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $this->assertEquals(
            'La dépense ne peut pas être dans le futur.',
            $this->getDescriptionByResponse($response)
        );
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testEndPointPostCreationAvecMontantZeroException(): void
    {
        $response= $this->post(
            url: '/depenses',
            json: [
                'montant' => 0,
                'horodatage' => '2024-11-19T19:30:00.000Z',
                'description' => 'Déplacement sur Montpellier pour l\'AFUP',
                'categorie' => '/enums/depenses/categorie/TRANSPORT'
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $this->assertEquals(
            'Le montant de la dépense n\'est pas positif.',
            $this->getDescriptionByResponse($response)
        );
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testEndPointPostCreationAvecMontantNegatifException(): void
    {
        $response = $this->post(
            url: '/depenses',
            json: [
                'montant' => -123,
                'horodatage' => '2024-11-19T19:30:00.000Z',
                'description' => 'Déplacement sur Montpellier pour l\'AFUP',
                'categorie' => '/enums/depenses/categorie/TRANSPORT'
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $this->assertEquals(
            'Le montant de la dépense n\'est pas positif.',
            $this->getDescriptionByResponse($response)
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testEndPointPostOk(): void
    {
        $this->post(
            url: '/depenses',
            json: [
                'montant' => 5000,
                'horodatage' => '2024-11-19T19:30:00.000Z',
                'description' => 'Déplacement sur Montpellier pour l\'AFUP',
                'categorie' => '/enums/depenses/categorie/TRANSPORT'
            ]
        );

        self::assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}