<?php declare(strict_types=1);

namespace App\Depense\Domain\VO;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class DepenseDescription
{
    #[ORM\Column(name: 'description', type: Types::STRING, nullable: false)]
    public ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }
}