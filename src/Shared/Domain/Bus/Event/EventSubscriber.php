<?php

namespace Marlemiesz\DDD\Shared\Domain\Bus\Event;

interface EventSubscriber
{
    public static function subscribedTo(): array;
}
