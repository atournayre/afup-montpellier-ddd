<?php declare(strict_types=1);

namespace App\Depense\Domain\VO;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class DepenseHorodatage
{
    #[ORM\Column(name: 'horodatage', type: Types::DATETIME_MUTABLE, nullable: false)]
    public ?DateTime $value;

    public function __construct(?DateTime $value)
    {
        $this->value = $value;
    }
}
