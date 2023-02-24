<?php

namespace Marlemiesz\DDD\Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Marlemiesz\DDD\Shared\Domain\Utils;
use Ramsey\Uuid\Uuid;

abstract class Event
{
    private readonly string $eventId;
    
    private readonly string $occurredOn;
    
    
    public function __construct(private readonly string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->eventId    = $eventId ?: Uuid::uuid4()->toString();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }
    
//    abstract public static function fromPrimitives(
//        string $aggregateId,
//        array $body,
//        string $eventId,
//        string $occurredOn
//    ): self;
    
    abstract public static function eventName(): string;
    
    abstract public function toPrimitives(): array;
    
    public function aggregateId(): string
    {
        return $this->aggregateId;
    }
    
    public function eventId(): string
    {
        return $this->eventId;
    }
    
    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
