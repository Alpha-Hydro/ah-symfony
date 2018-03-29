<?php

namespace App\Repository;

use App\Entity\MediaCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MediaCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaCategories[]    findAll()
 * @method MediaCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MediaCategories::class);
    }

//    /**
//     * @return MediaCategories[] Returns an array of MediaCategories objects
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
    public function findOneBySomeField($value): ?MediaCategories
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
