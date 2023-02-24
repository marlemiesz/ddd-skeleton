<?php

namespace Marlemiesz\DDD\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(protected int $value)
    {
    }
    
    public function value(): int
    {
        return $this->value;
    }
    
    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->value() > $other->value();
    }
    
    public function __toString(): string
    {
        return $this->value();
    }
}
