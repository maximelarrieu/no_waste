<?php

namespace App\Repository;

use App\Entity\Commodity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commodity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commodity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commodity[]    findAll()
 * @method Commodity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommodityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commodity::class);
    }

    // /**
    //  * @return Commodity[] Returns an array of Commodity objects
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
    public function findOneBySomeField($value): ?Commodity
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
