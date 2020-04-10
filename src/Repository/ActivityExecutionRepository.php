<?php

namespace App\Repository;

use App\Entity\ActivityExecution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ActivityExecution|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityExecution|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityExecution[]    findAll()
 * @method ActivityExecution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityExecutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityExecution::class);
    }

    // /**
    //  * @return ActivityExecution[] Returns an array of ActivityExecution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActivityExecution
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
