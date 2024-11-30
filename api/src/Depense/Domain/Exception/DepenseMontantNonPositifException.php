<?php declare(strict_types=1);

namespace App\Depense\Domain\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class DepenseMontantNonPositifException extends BadRequestHttpException
{
    public const MESSAGE = 'Le montant de la dépense n\'est pas positif.';

    /**
     * @param array<string, string|string[]> $headers Les en-têtes HTTP
     */
    public function __construct(string $message = self::MESSAGE, ?Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);
    }
}
