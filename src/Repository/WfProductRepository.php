<?php

namespace App\Repository;

use App\Entity\WfProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfProduct[]    findAll()
 * @method WfProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfProduct::class);
    }

//    /**
//     * @return WfProduct[] Returns an array of WfProduct objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WfProduct
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
