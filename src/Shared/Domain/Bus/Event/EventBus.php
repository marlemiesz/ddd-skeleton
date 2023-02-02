<?php

namespace Marlemiesz\DDD\Shared\Domain\Bus\Event;

interface EventBus
{
    public function publish(Event ...$events): void;
}
