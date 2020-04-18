<?php

namespace App\Repository;

use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    // /**
    //  * @return Participation[] Returns an array of Participation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByChildExecutionId($activityExecution_id): ?Participation
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('ae')
            ->join('p.activityExecution', 'ae')  
            ->addSelect('c')
            ->join('p.child', 'c') 
            ->where('p.activityExecution = :val')
            ->setParameter('val', $activityExecution_id);
        
        return $qb->getQuery()
        ->getOneOrNullResult();
        ;
    }
    
    public function findOneByUserExecutionId($activityExecution_id): ?Participation
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('ae')
            ->join('p.activityExecution', 'ae')  
            ->addSelect('u')
            ->join('p.user', 'u') 
            ->where('p.activityExecution = :val')
            ->setParameter('val', $activityExecution_id);
        
        return $qb->getQuery()
        ->getOneOrNullResult();
        ;
    }
    
}
