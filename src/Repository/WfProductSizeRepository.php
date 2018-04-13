<?php

namespace App\Repository;

use App\Entity\WfProductSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfProductSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfProductSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfProductSize[]    findAll()
 * @method WfProductSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfProductSizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfProductSize::class);
    }

//    /**
//     * @return WfProductSize[] Returns an array of WfProductSize objects
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
    public function findOneBySomeField($value): ?WfProductSize
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
