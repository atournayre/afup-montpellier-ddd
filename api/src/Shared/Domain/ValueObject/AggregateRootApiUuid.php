<?php

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

trait AggregateRootApiUuid
{
    #[ORM\Column(name: 'uuid', type: 'uuid', unique: true)]
    public AbstractUid $value;

    final public function __construct(?AbstractUid $value = null)
    {
        $this->value = $value ?? Uuid::v7();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
