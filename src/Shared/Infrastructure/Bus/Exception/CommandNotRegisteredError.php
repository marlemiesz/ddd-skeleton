<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Exception;

use RuntimeException;
use marlemiesz\DDD\Shared\Domain\Bus\Command\Command;
class CommandNotRegisteredError extends RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = $command::class;

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
    
}
