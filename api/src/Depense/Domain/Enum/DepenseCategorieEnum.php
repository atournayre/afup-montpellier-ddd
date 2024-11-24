<?php

namespace App\Depense\Domain\Enum;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Shared\Domain\Enum\EnumApiResourceTrait;

#[
    ApiResource(
        shortName: 'Depense Enum',
        types: ['https://schema.org/Enumeration'],
        normalizationContext: ['groups' => 'read']
    ),
    GetCollection(
        uriTemplate: '/enums/depenses/categorie',
        provider: self::class . '::getCases'
    ),
    Get(
        uriTemplate: '/enums/depenses/categorie/{id}',
        provider: self::class . '::getCase'
    )
]
enum DepenseCategorieEnum: string
{
    case LOGEMENT = 'LOGEMENT';
    case ALIMENTATION = 'ALIMENTATION';
    case TRANSPORT = 'TRANSPORT';
    case LOISIR = 'LOISIR';
    case SANTE = 'SANTE';
    case SHOPPING = 'SHOPPING';
    case SERVICES = 'SERVICE';
    case INVESTISSEMENT = 'INVESTISSEMENT';

    use EnumApiResourceTrait;
}
