<?php

namespace App\Repository;

use App\Entity\Couleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Couleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Couleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Couleur[]    findAll()
 * @method Couleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Couleur::class);
    }

    public function getLikeColor($search): ?Couleur
    {
        return $this->createQueryBuilder('c')
            ->where('c.couleur LIKE :search')
            ->setParameter('search', $search)
            ->getQuery()
            ->getResult();
    }
}
