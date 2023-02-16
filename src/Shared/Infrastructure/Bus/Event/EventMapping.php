<?php
namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Event;

use Marlemiesz\DDD\Shared\Domain\Bus\Event\EventSubscriber;
use RuntimeException;
use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;
class EventMapping
{
    private $mapping;
    
    public function __construct(iterable $mapping)
    {
        $this->mapping = reduce($this->eventsExtractor(), $mapping, []);
    }
    
    public function for(string $name)
    {
        if (!isset($this->mapping[$name])) {
            throw new RuntimeException("The Domain Event Class for <$name> doesn't exists or have no subscribers");
        }
        
        return $this->mapping[$name];
    }
    
    private function eventsExtractor(): callable
    {
        return fn (array $mapping, EventSubscriber $subscriber) => array_merge(
            $mapping,
            reindex(
                $this->eventNameExtractor(),
                $subscriber::subscribedTo()
            )
        );
    }
    
    private function eventNameExtractor(): callable
    {
        return static fn (string $eventClass): string => $eventClass::eventName();
    }
}
