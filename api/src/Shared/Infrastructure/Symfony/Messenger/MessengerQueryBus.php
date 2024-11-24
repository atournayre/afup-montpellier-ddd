<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Messenger;

use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @throws Throwable
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {
            $exception = $e->getNestedExceptions();

            throw $exception[0];
        }
    }
}
