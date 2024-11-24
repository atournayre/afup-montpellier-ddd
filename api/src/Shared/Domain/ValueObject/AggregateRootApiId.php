<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

trait AggregateRootApiId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    public int $value;

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
