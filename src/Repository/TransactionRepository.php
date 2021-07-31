<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function lastTransactionUser($user)
    {
        return $this->createQueryBuilder('t')
            ->join('t.purchase', 'purchase')
            ->join('purchase.customer','customer')
            ->join('customer.user','user')
            ->andWhere('user.id = :user')
            ->setParameter('user', $user)
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function allTransferUser($user, $filters = [])
    {
        $query = $this->createQueryBuilder('t')
            ->join('t.purchase', 'purchase')
            ->join('t.Account', 'account')
            ->join('purchase.customer','customer')
            ->join('customer.user', 'user')
            ->andWhere('user.id = :user')
            ->setParameter('user', $user)
        ;

        if(isset($filters['origin'])){
            $query->andWhere('account.id = :account')->setParameter('account', $filters['origin']);
        }

        if(isset($filters['destination'])){
            $query->andWhere('customer.account = :account_destination')->setParameter('account_destination', $filters['destination']);
        }

        return $query->getQuery()
        ->getResult();
    }

}
