<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function getActivesFilterUser($user, $account)
    {
        return $this->getActivesUserQb($user)
            ->andWhere('a.id != :accountExcept')
            ->setParameter('accountExcept', $account)
            ->getQuery()->getResult();
    }

    public function findAllAndFilter(User $user, $filters)
    {
        $query = $this->createQueryBuilder('a')
            ->join('a.customer','customer')
            ->join('customer.user','user')
            ->where('a.active = TRUE')
            ->andWhere('user.id != :userExcept')
            ->setParameter('userExcept', $user)
            ->orderBy('a.name','ASC');

        if (isset($filters['name'])) {
            $query->andWhere('customer.name LIKE :name')
                ->setParameter('name', '%'.$filters['name'].'%');
        }

        return $query->getQuery()->getResult();
    }


    public function getActivesUserQb(User $user)
    {
        return $this->createQueryBuilder('a')
            ->join('a.customer','customer')
            ->where('a.active = TRUE')
            ->andWhere('customer.user = :user')
            ->setParameter('user', $user)
            ->orderBy('a.id', 'ASC')
            ;
    }

    public function getActivesOtherAccounts($user)
    {
        return $this->createQueryBuilder('a')
            ->join('a.customer','customer')
            ->where('a.active = TRUE')
            ->andWhere('customer.user != :user')
            ->setParameter('user', $user)
            ->orderBy('a.id', 'ASC')
            ;
    }

    // /**
    //  * @return Account[] Returns an array of Account objects
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
    public function findOneBySomeField($value): ?Account
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
