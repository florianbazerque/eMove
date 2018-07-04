<?php

namespace App\Repository;

use App\Entity\StatusLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatusLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusLocation[]    findAll()
 * @method StatusLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusLocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatusLocation::class);
    }

//    /**
//     * @return StatusLocation[] Returns an array of StatusLocation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatusLocation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
