<?php declare(strict_types=1);

namespace App\Depense\Domain\VO;

use App\Depense\Domain\Enum\DepenseCategorieEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class DepenseCategorie
{
    #[ORM\Column(name: 'categorie', length: 255)]
    public DepenseCategorieEnum $value;

    public function __construct(DepenseCategorieEnum $value)
    {
        $this->value = $value;
    }

    public function estLogement(): bool
    {
        return $this->value === DepenseCategorieEnum::LOGEMENT;
    }

    public function estAlimentation(): bool
    {
        return $this->value === DepenseCategorieEnum::ALIMENTATION;
    }

    public function estTransport(): bool
    {
        return $this->value === DepenseCategorieEnum::TRANSPORT;
    }

    public function estLoisir(): bool
    {
        return $this->value === DepenseCategorieEnum::LOISIR;
    }

    public function estSante(): bool
    {
        return $this->value === DepenseCategorieEnum::SANTE;
    }

    public function estShopping(): bool
    {
        return $this->value === DepenseCategorieEnum::SHOPPING;
    }

    public function estServices(): bool
    {
        return $this->value === DepenseCategorieEnum::SERVICES;
    }

    public function estInvestissement(): bool
    {
        return $this->value === DepenseCategorieEnum::INVESTISSEMENT;
    }
}
