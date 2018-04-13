<?php

namespace App\Repository;

use App\Entity\WfProductConstruction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfProductConstruction|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfProductConstruction|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfProductConstruction[]    findAll()
 * @method WfProductConstruction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfProductConstructionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfProductConstruction::class);
    }

//    /**
//     * @return WfProductConstruction[] Returns an array of WfProductConstruction objects
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
    public function findOneBySomeField($value): ?WfProductConstruction
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
