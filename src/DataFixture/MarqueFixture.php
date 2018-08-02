<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 06/07/2018
 * Time: 11:47
 */

namespace App\DataFixture;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MarqueFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $marque = new Marque();
        $marque->setLabel("Citroen");
        $manager->persist($marque);
        $manager->flush();
        $this->addReference('marque', $marque);
    }
}