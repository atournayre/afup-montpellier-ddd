<?php declare(strict_types=1);

namespace App\Depense\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class DepenseDansLeFuturException extends BadRequestHttpException
{
    public const MESSAGE = 'La dépense ne peut pas être dans le futur';

    /**
     * @param array<string, string|string[]> $headers
     */
    public function __construct(string $message = self::MESSAGE, ?Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);
    }
}
