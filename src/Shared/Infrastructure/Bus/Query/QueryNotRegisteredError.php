<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Bus\Query;

use Marlemiesz\DDD\Shared\Domain\Bus\Query\Query;
class QueryNotRegisteredError extends \RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;
        
        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
