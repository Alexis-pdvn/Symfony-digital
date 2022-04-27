<?php

namespace App\Repository;

use App\Entity\ProductVariantPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductVariantPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductVariantPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductVariantPrice[]    findAll()
 * @method ProductVariantPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductVariantPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductVariantPrice::class);
    }

    // /**
    //  * @return ProductVariantPrice[] Returns an array of ProductVariantPrice objects
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

    /*
    public function findOneBySomeField($value): ?ProductVariantPrice
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
