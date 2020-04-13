<?php

namespace App\Repository;

use App\Entity\Cave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cave|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cave|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cave[]    findAll()
 * @method Cave[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cave::class);
    }

    // /**
    //  * @return Cave[] Returns an array of Cave objects
    //  */
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

    /**
    * @return Cave[] Returns an array of Cave objects
    */
    public function getWinesFromUserCave($idUser)
    {
        return $this->createQueryBuilder('c')
            ->where('c.id_user = :id_user')
            ->andWhere('c.quantite > :quantite')
            ->setParameter('id_user', $idUser)
            ->setParameter('quantite', 0)
            ->getQuery()
            ->getResult();
    }
}
