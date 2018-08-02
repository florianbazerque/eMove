<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 23/07/2018
 * Time: 14:34
 */

namespace App\DataFixture;

use App\Entity\StatusLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class StatusLocationFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loue = new StatusLocation();
        $loue->setLabel('En location');
        $reserve = new StatusLocation();
        $reserve->setLabel('Réservé');
        $rendu = new StatusLocation();
        $rendu->setLabel('Retourné');
        $manager->persist($loue);
        $manager->persist($reserve);
        $manager->persist($rendu);
        $manager->flush();
    }
}