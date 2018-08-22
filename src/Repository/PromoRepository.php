<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Promo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promo[]    findAll()
 * @method Promo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    public function Promo($vehicule, $marque)
    {
        $time =  (new \DateTime());
        return $this->createQueryBuilder('p')
            ->andWhere('p.startDate < :start')
            ->andWhere('p.endDate > :end')
            ->andWhere('p.vehicule = '.$vehicule.' OR p.marque = '.$marque.'')
            ->setParameter('start', $time)
            ->setParameter('end', $time)
            ->orderBy('p.startDate', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function currentPromoVehicule()
    {
        $time =  (new \DateTime());
        return $this->createQueryBuilder('p')
            ->andWhere('p.startDate < :start')
            ->andWhere('p.endDate > :end')
            ->setParameter('start', $time)
            ->setParameter('end', $time)
            ->orWhere('p.vehicule IS NOT NULL')
            ->orWhere('p.marque IS NOT NULL')
            ->orderBy('p.startDate', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Promo[] Returns an array of Promo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
