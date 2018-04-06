<?php

namespace App\Repository;

use App\Entity\ProductParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductParams[]    findAll()
 * @method ProductParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductParamsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductParams::class);
    }

//    /**
//     * @return ProductParams[] Returns an array of ProductParams objects
//     */
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
    public function findOneBySomeField($value): ?ProductParams
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
