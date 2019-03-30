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

    public function updateRank($id, $lesson, $content, $rank)
    {
        return $this->createQueryBuilder('r')
            ->update(LessonContent::class, 'r')
            ->set('r.lesson', '?1')
            ->set('r.rank', '?2')
            ->where('r.id = ?3')
            ->setParameters(array(1 => $lesson, 2 => $rank, 3 => $id))
            ->getQuery()
            ->getResult()
            ;
    }

    public function deleteDataInLessonContent($id)
    {
        return $this->createQueryBuilder('z')
            ->delete(LessonContent::class, 'z')
            ->where('z.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
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
