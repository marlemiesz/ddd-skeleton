<?php

namespace Marlemiesz\DDD\Shared\Infrastructure\Persistence;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Marlemiesz\DDD\Shared\Domain\Aggregate\Aggregate;

abstract class DoctrineRepository extends ServiceEntityRepository
{
    private $entityManager;

   public function __construct(ManagerRegistry $registry, string $entityClass)
   {
       parent::__construct($registry, $entityClass);
   }
    
    protected function entityManager()
    {
        return $this->getEntityManager();
    }
    
    protected function persist(Aggregate $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush($entity);
    }
    
    abstract public function getEntity(): Aggregate;
    
    protected function remove(Aggregate $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }
    
   
}
