<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 12/07/2018
 * Time: 14:49
 */

namespace App\Manager;


use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VehiculeManager
{
    /** @var EntityManagerInterface */
    private $em;
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function search($name)
    {
        if ($name == '') {
            return [];
        }
        /** @var VehiculeRepository $vehiculeRepository */
        $vehiculeRepository = $this->em->getRepository(Vehicule::class);
        $vehicules = $vehiculeRepository->searchAction($name);
        return $vehicules;
    }

    public function filter($agence, $vehicule, $km_min, $km_max, $price_max, $price_min, $color)
    {
        if ($agence == '' && $vehicule == '' && $km_min == ''
            && $km_max == '' && $price_max == '' && $price_min == '' && $color == '') {
            return [];
        }
        /** @var VehiculeRepository $vehiculeRepository */
        $vehiculeRepository = $this->em->getRepository(Vehicule::class);
        $vehicules = $vehiculeRepository->filterAction($agence, $vehicule, $km_min, $km_max, $price_max, $price_min, $color);
        return $vehicules;
    }

}