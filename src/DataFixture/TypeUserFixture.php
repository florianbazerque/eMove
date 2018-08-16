<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 23/07/2018
 * Time: 16:07
 */

namespace App\DataFixture;

use App\Entity\TypeUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class TypeUserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new TypeUser();
        $admin->setLabel('Administrateur');
        $user = new TypeUser();
        $user->setLabel('Utilisateur');
        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
        $this->addReference('typeuser', $admin);
    }
}