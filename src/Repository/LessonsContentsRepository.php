<?php

namespace App\Repository;

use App\Entity\LessonsContents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LessonsContents|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonsContents|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonsContents[]    findAll()
 * @method LessonsContents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonsContentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LessonsContents::class);
    }

    // /**
    //  * @return LessonsContents[] Returns an array of LessonsContents objects
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
    public function findOneBySomeField($value): ?LessonsContents
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
