<?php

namespace App\Repository;

use App\Entity\AdresseFacturation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdresseFacturation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdresseFacturation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdresseFacturation[]    findAll()
 * @method AdresseFacturation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseFacturationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdresseFacturation::class);
    }

//    /**
//     * @return AdresseFacturation[] Returns an array of AdresseFacturation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdresseFacturation
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
