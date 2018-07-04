<?php

namespace App\Repository;

use App\Entity\StatusFacture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatusFacture|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusFacture|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusFacture[]    findAll()
 * @method StatusFacture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusFactureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatusFacture::class);
    }

//    /**
//     * @return StatusFacture[] Returns an array of StatusFacture objects
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
    public function findOneBySomeField($value): ?StatusFacture
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
