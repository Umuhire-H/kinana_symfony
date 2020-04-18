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

    /**
     * @return ActivityExecution[] Returns an array of ActivityExecution objects
     */
    
    public function findAllByActivityId($activity_id, $today) : array
    {
        $qb = $this->createQueryBuilder('ae')
            ->addSelect('a')
            ->addSelect('ua')
            ->join('ae.activity', 'a')  
            ->join('ae.userAnimators', 'ua')  
            ->where('ae.activity = :idActiviy')
            ->andWhere('ae.date >= :datelimit')
            ->setParameter('idActiviy', $activity_id)
            ->setParameter('datelimit', $today)
            ->orderBy('ae.date', 'ASC');
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }

    public function findOnebyId($activity_id) : ?ActivityExecution
    {
        $qb = $this->createQueryBuilder('ae')
            ->addSelect('a')
            ->addSelect('ua')
            ->join('ae.activity', 'a')  
            ->join('ae.userAnimators', 'ua')  
            ->where('ae.activity = :idActiviy')
            ->andWhere('ae.date >= :datelimit')
            ->setParameter('idActiviy', $activity_id);
        return $qb->getQuery()
            ->getOneOrNullResult();   
        
    }
    
}
