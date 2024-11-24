<?php declare(strict_types=1);

namespace App\Depense\Domain\VO;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class DepenseMontant
{
    #[ORM\Column(name: 'montant', type: Types::INTEGER, nullable: false)]
    public ?int $value;

    public function __construct(?int $montant)
    {
        $this->value = $montant;
    }
}
