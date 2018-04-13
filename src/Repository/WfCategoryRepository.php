<?php

namespace App\Repository;

use App\Entity\WfCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WfCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method WfCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method WfCategory[]    findAll()
 * @method WfCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WfCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WfCategory::class);
    }

    /**
     * @return WfCategory[] Returns an array of WfCategory objects
     */
    public function findByRootCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = true')
            ->andWhere('c.deleted = false')
            ->andWhere('c.parent is null')
            ->orderBy('c.sorting', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param WfCategory $category
     * @return WfCategory[]
     */
    public function findByChildren(WfCategory $category): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = true')
            ->andWhere('c.deleted = false')
            ->andWhere('c.parent = :category')
            ->setParameter('category', $category)
            ->orderBy('c.sorting', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $value
     * @return WfCategory|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByFullPath(string $value): ?WfCategory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.fullPath = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

//    /**
//     * @return WfCategory[] Returns an array of WfCategory objects
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
    public function findOneBySomeField($value): ?WfCategory
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
