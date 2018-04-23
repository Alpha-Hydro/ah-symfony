<?php

namespace App\Repository;

use App\Entity\ManufactureCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ManufactureCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManufactureCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManufactureCategories[]    findAll()
 * @method ManufactureCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManufactureCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ManufactureCategories::class);
    }

    /**
     * @return ManufactureCategories[]
     */
    public function findByRootCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = true')
            ->andWhere('c.deleted = false')
            ->orderBy('c.sorting', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return ManufactureCategories[] Returns an array of ManufactureCategories objects
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
    public function findOneBySomeField($value): ?ManufactureCategories
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
