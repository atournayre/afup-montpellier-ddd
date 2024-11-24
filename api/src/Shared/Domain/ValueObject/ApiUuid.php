<?php

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Embeddable]
final class ApiUuid implements Stringable
{
    use AggregateRootApiUuid;
}
