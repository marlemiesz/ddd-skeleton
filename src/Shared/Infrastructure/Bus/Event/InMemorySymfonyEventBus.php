<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Event;

use CallableFirstParameterExtractor;
use Marlemiesz\DDD\Shared\Domain\Bus\Event\Event;
use Marlemiesz\DDD\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBus implements EventBus
{
    private readonly MessageBus $bus;
    
    public function __construct(iterable $subscribers = [])
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables($subscribers)
                    )
                ),
            ]
        );
    }
    public function publish(Event ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException) {
            }
        }
    }
}
