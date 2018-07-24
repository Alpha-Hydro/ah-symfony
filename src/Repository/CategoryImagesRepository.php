<?php

namespace App\Repository;

use App\Entity\CategoryImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryImages[]    findAll()
 * @method CategoryImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryImagesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryImages::class);
    }

//    /**
//     * @return CategoryImages[] Returns an array of CategoryImages objects
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
    public function findOneBySomeField($value): ?CategoryImages
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
