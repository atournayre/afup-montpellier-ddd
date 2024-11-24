<?php declare(strict_types=1);

namespace App\Shared\Domain\Enum;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Serializer\Annotation\Groups;

trait EnumApiResourceTrait
{
    public static function getCases(): array
    {
        return self::cases();
    }

    public static function getCase(Operation $operation, array $uriVariables)
    {
        $name = $uriVariables['id'] ?? null;
        return constant(self::class . "::$name");
    }

    public static function fromIri(string $iri): self
    {
        $shortName = basename($iri);
        return self::from($shortName);
    }

    #[Groups('read')]
    #[ApiProperty(types: ['https://schema.org/name'])]
    public function getValue(): string
    {
        return $this->value;
    }

    #[ApiProperty(types: ['https://schema.org/identifier'])]
    public function getId(): string
    {
        return $this->name;
    }
}
