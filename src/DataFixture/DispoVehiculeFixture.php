<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 06/07/2018
 * Time: 11:38
 */

namespace App\DataFixture;

use App\Entity\DispoVehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DispoVehiculeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $dispo = new DispoVehicule();
        $dispo->setLabel('Disponible');
        $dispo2 = new DispoVehicule();
        $dispo2->setLabel('Indisponible');
        $manager->persist($dispo);
        $manager->persist($dispo2);
        $manager->flush();
        $this->addReference('dispovehicule', $dispo);
        $this->addReference('indisponible', $dispo2);
    }
}