<?php

namespace App\Repository;

use App\Entity\WfCategoryProperties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfCategoryProperties|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfCategoryProperties|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfCategoryProperties[]    findAll()
 * @method WfCategoryProperties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfCategoryPropertiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfCategoryProperties::class);
    }

//    /**
//     * @return WfCategoryProperties[] Returns an array of WfCategoryProperties objects
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
    public function findOneBySomeField($value): ?WfCategoryProperties
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
