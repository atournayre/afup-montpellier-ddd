<?php declare(strict_types=1);

namespace App\Depense\Infrastructure\Doctrine;

use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\Repository\DepenseRepositoryInterface;
use App\Shared\Domain\ValueObject\ApiUuid;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineDepenseRepository extends DoctrineRepository implements DepenseRepositoryInterface
{
    private const ENTITY_CLASS = Depense::class;
    private const ALIAS = 'demande';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Depense $depense): void
    {
        $this->em->persist($depense);
        $this->em->flush();
    }

    public function findByApiUuid(ApiUuid $apiUuid): ?Depense
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy(['uuid.value' => $apiUuid->value]);
    }

    public function findAll(): static
    {
        return $this;
    }
}
