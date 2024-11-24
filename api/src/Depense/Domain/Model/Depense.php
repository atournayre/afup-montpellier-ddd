<?php declare(strict_types=1);

namespace App\Depense\Domain\Model;

use App\Depense\Domain\VO\DepenseCategorie;
use App\Depense\Domain\VO\DepenseDescription;
use App\Depense\Domain\VO\DepenseHorodatage;
use App\Depense\Domain\VO\DepenseMontant;
use App\Shared\Domain\Model\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Depense extends BaseEntity
{
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private DepenseMontant     $montant,
        #[ORM\Embedded(columnPrefix: false)]
        private DepenseHorodatage  $horodatage,
        #[ORM\Embedded(columnPrefix: false)]
        private DepenseDescription $description,
        #[ORM\Embedded(columnPrefix: false)]
        private DepenseCategorie   $categorie,
    )
    {
        parent::__construct();
    }

    public function montant(): DepenseMontant
    {
        return $this->montant;
    }

    public function horodatage(): DepenseHorodatage
    {
        return $this->horodatage;
    }

    public function description(): DepenseDescription
    {
        return $this->description;
    }

    public function categorie(): DepenseCategorie
    {
        return $this->categorie;
    }
}
