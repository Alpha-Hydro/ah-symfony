<?php

namespace App\Repository;

use App\Entity\WfProductControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfProductControl|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfProductControl|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfProductControl[]    findAll()
 * @method WfProductControl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfProductControlRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfProductControl::class);
    }

//    /**
//     * @return WfProductControl[] Returns an array of WfProductControl objects
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
    public function findOneBySomeField($value): ?WfProductControl
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
