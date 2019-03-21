<?php

namespace App\Repository;

use App\Entity\LessonContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LessonContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonContent[]    findAll()
 * @method LessonContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonContentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LessonContent::class);
    }

    // /**
    //  * @return LessonContent[] Returns an array of LessonContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LessonContent
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
