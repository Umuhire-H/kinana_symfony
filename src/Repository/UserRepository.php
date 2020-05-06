<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findTeam()
    {
        $qb= $this->createQueryBuilder('u')
            ->where('u.roles LIKE :role OR u.roles LIKE :role2')
            ->setParameter('role', '%ROLE_USER_ANIMATOR%' )
            ->setParameter('role2', '%ROLE_USER_TRADUCTOR%')
            ->leftJoin('u.activityExecutions', 'ae')
            ->addSelect('ae')
            ->leftJoin('ae.activity', 'a')
            ->addSelect('a')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
           ->getResult()
        ;
        //dd($qb);
        return $qb;
    }
    
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    // public function findTeamRoles()
    // {
    //     $qb= $this->createQueryBuilder('u')
    //         ->select('u.roles')
    //         ->where('u.roles LIKE :role OR u.roles LIKE :role2')
    //         ->setParameter('role', '%ROLE_USER_ANIMATOR%' )
    //         ->setParameter('role2', '%ROLE_USER_TRADUCTOR%')
    //        // ->orderBy('u.id', 'ASC')
    //         ->getQuery();
    //     $array=$qb->getArrayResult();
        
    //     dd($array);
    //     return $array;
    // }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
