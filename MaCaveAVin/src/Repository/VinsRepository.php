<?php

namespace App\Repository;

use App\Entity\Vins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Vins|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vins|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vins[]    findAll()
 * @method Vins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vins::class);
    }

    // /**
    //  * @return Vins[] Returns an array of Vins objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vins
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
