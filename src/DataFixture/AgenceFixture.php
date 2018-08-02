<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 16:33
 */

namespace App\DataFixture;

use App\Entity\Agence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AgenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $agence = new Agence();
        $agence->setLabel('Paris');
        $agence1 = new Agence();
        $agence1->setLabel('Lyon');
        $manager->persist($agence);
        $manager->persist($agence1);
        $manager->flush();
        $this->addReference('agence', $agence);
    }

}