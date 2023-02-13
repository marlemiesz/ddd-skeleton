<?php

namespace Marlemiesz\DDD\Shared\Domain\Aggregate;

use Marlemiesz\DDD\Shared\Domain\Bus\Event\Event;

abstract class Aggregate
{
    private array $domainEvents = [];
    
    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];
        
        return $domainEvents;
    }
    
    final protected function record(Event $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
