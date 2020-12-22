<?php

namespace App\Repository;

use App\Entity\Business;
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

    public function getCommoditiesByBusiness(Business $business) {
        return $this->createQueryBuilder('commodity')
            ->innerJoin('commodity.business', 'business')
            ->where('business = :business')
            ->setParameter('business', $business)
            ->getQuery()
            ->getResult();
    }
}
