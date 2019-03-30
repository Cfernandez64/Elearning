<?php

namespace App\Repository;

use App\Entity\Advance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Advance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advance[]    findAll()
 * @method Advance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advance::class);
    }

    // /**
    //  * @return Advance[] Returns an array of Advance objects
    //  */

    public function removeAdvance($id)
    {
        return $this->createQueryBuilder('z')
            ->delete(Advance::class, 'z')
            ->where('z.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Advance
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
