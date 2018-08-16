<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicule[]    findAll()
 * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

//    /**
//     * @return Vehicule[] Returns an array of Vehicule objects
//     */
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
    public function findByNot($field, $value)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->where($qb->expr()->not($qb->expr()->eq('a.'.$field, '?1')))
            ->andWhere('a.dispoVehicule = 1');
        $qb->setParameter(1, $value);

        return $qb->getQuery()
            ->getResult();
    }

    public function updateDispo($userId)
    {
        $qB = $this->createQueryBuilder('p');
        //$qB = $this->getEntityManager()->createQueryBuilder();
        $qB ->update('App:Vehicule', 'p')
            ->set('p.dispoVehicule', '?1')
            ->where('p.id = ?2')
            ->setParameter(1, 2)
            ->setParameter(2, $userId);

        return $qB->getQuery();
    }

    public function searchAction($search){
        $qb = $this->createQueryBuilder('f')
            ->where('f.modele like :search')
            ->setParameter('search', '%' . $search . '%');
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function filterAction($agence, $vehicule, $km_min, $km_max, $price_max, $price_min, $color)
    {

        $qb = $this->createQueryBuilder('f')
            ->select('f')
            ->where('f.dispoVehicule = 1');
        if (isset($agence) && $agence != '' && $agence != 0) {
            var_dump($agence);
            $req = '';
            foreach ($agence as $item => $key) {
                if ($item == "0")
                    $req = 'f.agence = '.$key;
                else
                    $req = $req.' OR f.agence = '.$key;
            }
            $qb->andWhere($req);
        }

        if (isset($vehicule) && $vehicule != '' && $vehicule != 0) {
            var_dump($vehicule);
            $req = '';
            foreach ($vehicule as $item => $key) {
                if ($item == "0")
                    $req = 'f.typeVehicule = '.$key;
                else
                    $req = $req.' OR f.typeVehicule = '.$key;
            }
            $qb->andWhere($req);
        }

        if (isset($color) && $color != '' && $color != 0) {
            var_dump($color);
            $req = '';
            foreach ($color as $item => $key) {
                if ($item == "0")
                    $req = "f.couleur LIKE '%".$key."%'";
                else
                    $req = $req." OR f.couleur LIKE '%".$key."%'";
            }
            $qb->andWhere($req);
        }

            if ($km_min != '')
                $qb->andwhere('f.nbKm > :kmin')
                    ->setParameter('kmin',$km_min);
            if ($km_max != '' && $km_max != 0)
                $qb->andwhere('f.nbKm < :kmax')
                    ->setParameter('kmax',$km_max);
            if ($price_min != '')
                $qb->andwhere('f.prixAchat > :pmin')
                    ->setParameter('pmin',$price_min);
            if ($price_max != '' && $price_max != 0)
                $qb->andwhere('f.prixAchat < :pmax')
                    ->setParameter('pmax',$price_max);

        return $qb
            ->getQuery()
            ->getResult();
    }

}
