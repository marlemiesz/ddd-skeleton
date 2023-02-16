<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Persistence;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Marlemiesz\DDD\Shared\Domain\Aggregate\Aggregate;

abstract class DoctrineRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }
    
    protected function entityManager()
    {
        return $this->entityManager;
    }
    
    protected function persist(Aggregate $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }
    
    abstract public function getEntity(): Aggregate;
    
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
