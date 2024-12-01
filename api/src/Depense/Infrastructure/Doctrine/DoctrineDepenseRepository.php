<?php declare(strict_types=1);

namespace App\Depense\Infrastructure\Doctrine;

use App\Depense\Domain\Model\Depense;
use App\Depense\Domain\Repository\DepenseRepositoryInterface;
use App\Shared\Domain\ValueObject\ApiUuid;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends DoctrineRepository<Depense>
 */
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
        // TODO Ne pourrait on pas simplifier les méthodes find* ?
        return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy(['uuid.value' => $apiUuid->value]);
    }

    public function findAll(): static
    {
        // TODO Pas très intuitif quand on est habitué à Doctrine, on s'attend à ce que la méthode findAll() retourne un tableau, mais génial couplé à l'usage de la pagination !
        return $this;
    }
}
