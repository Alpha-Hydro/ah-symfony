<?php

namespace App\Repository;

use App\Entity\ModificationParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ModificationParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModificationParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModificationParams[]    findAll()
 * @method ModificationParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModificationParamsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModificationParams::class);
    }

//    /**
//     * @return ModificationParams[] Returns an array of ModificationParams objects
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
    public function findOneBySomeField($value): ?ModificationParams
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
