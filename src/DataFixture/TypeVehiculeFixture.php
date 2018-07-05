<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 16:33
 */

namespace App\DataFixture;

use App\Entity\TypeVehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeVehiculeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $voiture = new TypeVehicule();
        $voiture->setLabel('Voiture');
        $scooter = new TypeVehicule();
        $scooter->setLabel('Scooter');
        $manager->persist($voiture);
        $manager->persist($scooter);
        $manager->flush();
    }

}