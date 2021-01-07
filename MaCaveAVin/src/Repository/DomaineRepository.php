<?php

namespace App\Repository;

use App\Entity\Domaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Domaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domaine[]    findAll()
 * @method Domaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domaine::class);
    }

    /**
     * @return Array
     * Cherche si le domaine existe
     */
    public function searchDomain($domain)
    {
        return $this->createQueryBuilder('d')
            ->where('d.domaine = :domaine')
            ->setParameter('domaine', $domain)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $search
     * @return Domaine[] Returns an array of Couleur objects
     */
    public function getLikeDomain($search)
    {
        return $this->createQueryBuilder('d')
            ->where('d.domaine LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }
}
