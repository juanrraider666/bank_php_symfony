<?php

namespace App\Repository;

use App\Entity\CustomerPurchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomerPurchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerPurchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerPurchase[]    findAll()
 * @method CustomerPurchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerPurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerPurchase::class);
    }

    // /**
    //  * @return CustomerPurchase[] Returns an array of CustomerPurchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomerPurchase
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
