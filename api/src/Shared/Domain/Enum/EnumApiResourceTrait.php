<?php declare(strict_types=1);

namespace App\Shared\Domain\Enum;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Serializer\Annotation\Groups;

trait EnumApiResourceTrait
{
    /**
     * @return array<int, static>
     */
    public static function getCases(): array
    {
        return self::cases();
    }

    /**
     * @param Operation $operation
     * @param array<string, string> $uriVariables
     * @return static
     */
    // TODO Domaine mais couplé au framework ?
    // TODO Considéré comme non utilisé par l'IDE mais utilisé dans l'exposition comme resource dans l'enum lui même.
    public static function getCase(Operation $operation, array $uriVariables): static
    {
        $name = $uriVariables['id'] ?? null;
        /** @var static */
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
