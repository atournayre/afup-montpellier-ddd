<?php
declare(strict_types=1);

namespace App\Depense\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

final class DepenseInvalide extends BadRequestHttpException implements DepenseExceptionInterface
{
    /**
     * @param array<string, string|string[]> $headers Les en-têtes HTTP
     */
    public function __construct(string $message, ?Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);
    }

    public static function carLeMontantNEstPasPositif(): self
    {
        return new self('Le montant de la dépense n\'est pas positif.');
    }

    public static function carLaDateEstDansLeFutur(): self
    {
        return new self('La dépense ne peut pas être dans le futur.');
    }
}
