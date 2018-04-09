<?php

namespace App\Repository;

use App\Entity\ModificationParamsValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModificationParamsValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModificationParamsValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModificationParamsValues[]    findAll()
 * @method ModificationParamsValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModificationParamsValueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModificationParamsValues::class);
    }

//    /**
//     * @return ModificationParamsValues[] Returns an array of ModificationParamsValues objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModificationParamsValues
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
