<?php declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Embeddable]
class ApiId implements Stringable
{
    use AggregateRootApiId;
}
