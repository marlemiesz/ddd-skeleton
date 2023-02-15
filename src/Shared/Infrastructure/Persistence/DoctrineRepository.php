<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Persistence;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Marlemiesz\DDD\Shared\Domain\Aggregate\Aggregate;

abstract class DoctrineRepository
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }
    
    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }
    
    protected function persist(Aggregate $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }
    
    protected function remove(Aggregate $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }
    
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}
