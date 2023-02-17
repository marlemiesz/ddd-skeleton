<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Query;

use CallableFirstParameterExtractor;
use Marlemiesz\DDD\Shared\Domain\Bus\Query\Query;
use Marlemiesz\DDD\Shared\Domain\Bus\Query\QueryBus;
use Marlemiesz\DDD\Shared\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly class InMemorySymfonyQueryBus implements QueryBus
{
    private MessageBus $bus;
    
    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($queryHandlers))
                ),
            ]
        );
    }
    public function ask(Query $query): ?Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);
            
            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new QueryNotRegisteredError($query);
        }
    }
}
