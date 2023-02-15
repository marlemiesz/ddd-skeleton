<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Command;

use CallableFirstParameterExtractor;
use Marlemiesz\DDD\Shared\Infrastructure\Bus\Exception\CommandNotRegisteredError;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Marlemiesz\DDD\Shared\Domain\Bus\Command\Command;
use Marlemiesz\DDD\Shared\Domain\Bus\Command\CommandBus;
final class InMemorySymfonyCommandBus implements CommandBus
{
    private readonly MessageBus $bus;

    public function __construct(iterable $commandHandlers = [])
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
                ),
            ]
        );
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
