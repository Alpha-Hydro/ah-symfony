<?php

namespace App\Repository;

use App\Entity\CategoriesIdxTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoriesIdxTrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriesIdxTrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriesIdxTrait[]    findAll()
 * @method CategoriesIdxTrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesIdxTraitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoriesIdxTrait::class);
    }

//    /**
//     * @return CategoriesIdxTrait[] Returns an array of CategoriesIdxTrait objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoriesIdxTrait
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
