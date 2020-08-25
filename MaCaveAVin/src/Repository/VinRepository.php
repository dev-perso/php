<?php

namespace App\Repository;

use App\Entity\Vin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vin[]    findAll()
 * @method Vin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vin::class);
    }

    // /**
    //  * @return Vin[] Returns an array of Vin objects
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

    /**
     * @return Vin
     * Cherche si le Vin existe
     */
    public function searchIfExist($appellation, $couleur, $domaine, $region, $annee)
    {
        return $this->createQueryBuilder('v')
            ->where('v.appellation = :appellation')
            ->andWhere('v.id_couleur = :id_couleur')
            ->andWhere('v.id_domaine = :id_domaine')
            ->andWhere('v.id_region = :id_region')
            ->andWhere('v.annee = :annee')
            ->setParameter('appellation', $appellation)
            ->setParameter('id_couleur', $couleur)
            ->setParameter('id_domaine', $domaine)
            ->setParameter('id_region', $region)
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Vin[] Returns an array of Vin objects
     * Récupère tous les vins de l'utilisateur avec le filtre de la couleur en cours
     */
    public function getUserWineWithColorFilter($idUser, $couleur)
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.users', 'User')
            ->where('User.id_user = :id_user')
            ->andWhere('v.couleur = :couleur')
            ->setParameter('id_user', $idUser)
            ->setParameter('couleur', $couleur)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Vin[] Returns an array of Vin objects
     * Récupère tous les vins de l'utilisateur avec le filtre de la region en cours
     */
    public function getUserWineWithRegionFilter($idUser, $region)
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.users', 'User')
            ->where('User.id_user = :id_user')
            ->andWhere('v.region = :region')
            ->setParameter('id_user', $idUser)
            ->setParameter('region', $region)
            ->getQuery()
            ->getResult();
    }

}
