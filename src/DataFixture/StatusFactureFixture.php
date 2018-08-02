<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 23/07/2018
 * Time: 14:21
 */

namespace App\DataFixture;

use App\Entity\StatusFacture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StatusFactureFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $signe = new StatusFacture();
        $signe->setLabel('A signé');
        $dispo = new StatusFacture();
        $dispo->setLabel('Disponible');
        $manager->persist($signe);
        $manager->persist($dispo);
        $manager->flush();
    }
}