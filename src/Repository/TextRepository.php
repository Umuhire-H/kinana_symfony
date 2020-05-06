<?php

namespace App\Repository;

use App\Entity\Text;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Text|null find($id, $lockMode = null, $lockVersion = null)
 * @method Text|null findOneBy(array $criteria, array $orderBy = null)
 * @method Text[]    findAll()
 * @method Text[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Text::class);
    }

    /**
     * @return Text[] Returns an array of Text objects
     */
    
    public function findAllTranslations()
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.userTranslator', 'ut')
            ->addSelect('ut')
            ->orderBy('t.dateReturn', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     /**
     * @return Text[] Returns an array of Text objects
     */
    
    public function findAllExcept($value)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.userTranslator', 'ut')
            ->addSelect('ut')
            ->where('t.id <> :val')
            ->setParameter('val', $value)
            ->orderBy('t.dateReturn', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findThisById($value): ?Text
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.userRequester', 'ur')
            ->addSelect('ur')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Text
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
