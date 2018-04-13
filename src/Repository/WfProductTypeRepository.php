<?php

namespace App\Repository;

use App\Entity\WfProductType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfProductType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfProductType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfProductType[]    findAll()
 * @method WfProductType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfProductTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfProductType::class);
    }

//    /**
//     * @return WfProductType[] Returns an array of WfProductType objects
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
    public function findOneBySomeField($value): ?WfProductType
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
