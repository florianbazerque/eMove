<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 08/07/2018
 * Time: 21:17
 */

namespace App\DataFixture;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use App\Entity\User;
use App\Entity\TypeUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function  load(ObjectManager $manager)
    {
        //$encoder = new UserPasswordEncoder();

        $user1 = new User();
        $user1->setFirstName("admin");
        $user1->setBirthDate(new \DateTimeImmutable());
        $user1->setTypeUser((new  TypeUser())->setLabel("Administrateur"));
        $user1->setEmail("admin.emove@gmail.com");
        $user1->setAdresse("25 Rue Claude Tillier, 75012 Paris");
        $user1->setTelNum("0145675443");
        $user1->setFidelityPoint(0);
        $user1->setLicenceNum("aucune");
        //$password =  $encoder->encodePassword($user1,"pass_1234");
        $user1->setPassword("admin");

        $manager->persist($user1);
        $manager->flush();
    }
}