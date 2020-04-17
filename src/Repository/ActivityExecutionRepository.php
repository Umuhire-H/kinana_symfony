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
    
    public function findAllByIdActivity($id_activity) : array
    {
        $qb = $this->createQueryBuilder('ae')
            ->where('ae.activity = :idActiviy')
            ->setParameter('idActiviy', $id_activity)
            ->orderBy('ae.date', 'ASC');
        $query = $qb->getQuery();
        //return $query->execute();
        $res = $query->getResult();
        return $res;
    }

    
    
}
