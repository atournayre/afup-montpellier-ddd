<?php

declare(strict_types=1);

namespace App\Depense\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Depense\Domain\Enum\DepenseCategorieEnum;
use App\Depense\Domain\Model\Depense;
use App\Depense\Infrastructure\ApiPlatform\State\Processor\AjouterDepenseProcessor;
use App\Depense\Infrastructure\ApiPlatform\State\Provider\TrouverDepenseProvider;
use App\Depense\Infrastructure\ApiPlatform\State\Provider\TrouverToutesLesDepensesProvider;
use ArrayObject;
use Symfony\Component\Uid\AbstractUid;
use ApiPlatform\OpenApi\Model;

#[ApiResource(
    shortName: 'Depense',
    operations: [
        new GetCollection(
            provider: TrouverToutesLesDepensesProvider::class
        ),
        new Get(
            provider: TrouverDepenseProvider::class,
        ),
        new Post(
            openapi: new Model\Operation(
                summary: 'Ajouter une dépense',
                requestBody: new Model\RequestBody(
                    content: new ArrayObject([
                        'application/ld+json' => [
                            'example' => [
                                'montant' => 5000,
                                'horodatage' => '2024-11-19T19:30:00.000Z',
                                'description' => 'Déplacement sur Montpellier pour l\'AFUP',
                                'categorie' => '/enums/depenses/categorie/TRANSPORT',
                            ]
                        ]
                    ])
                )
            ),
            processor: AjouterDepenseProcessor::class
        ),
    ]
)]
class DepenseResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: false)]
        public ?int                  $id = null,
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?AbstractUid          $uuid = null,
        public ?int                  $montant = null,
        public ?string               $horodatage = null,
        public ?string               $description = null,
        public ?DepenseCategorieEnum $categorie = null,
    )
    {
    }

    public static function fromModel(Depense $depense): self
    {
        return new self(
            id: $depense->id()->value,
            uuid: $depense->uuid()->value,
            montant: $depense->montant()->value,
            horodatage: $depense->horodatage()->value->format('Y-m-d\TH:i:s.000\Z'),
            description: $depense->description()->value,
            categorie: $depense->categorie()->value,
        );
    }
}
