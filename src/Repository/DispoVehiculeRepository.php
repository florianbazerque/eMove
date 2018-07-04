<?php

namespace App\Repository;

use App\Entity\DispoVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DispoVehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method DispoVehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method DispoVehicule[]    findAll()
 * @method DispoVehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DispoVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DispoVehicule::class);
    }

//    /**
//     * @return DispoVehicule[] Returns an array of DispoVehicule objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DispoVehicule
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
