<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 23/07/2018
 * Time: 15:56
 */

namespace App\DataFixture;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //$passwordEncoder = new UserPasswordEncoder();

        $user = new User();
        $user->setTypeUser($this->getReference('typeuser'));
        $user->setFirstName('Toto');
        $user->setLastName('Titi');
        $user->setEmail('contact@ecole-ipssi.com');
        $user->setPassword('$2y$10$bSL/NJLGo..PxhoGU8zoz.N9jwIofTY4AaCssjujRKhOP1uZeJxNa');
        $user->setBirthDate(new \DateTime('1993/01/01'));
        $user->setAdresse('17 Rue Claude Tillier,');
        $user->setFidelityPoint(70);
        $user->setTelNum(06060606006);
        $user->setLicenceNum("AA588F6Z");
        $manager->persist($user);
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            TypeUserFixture::class
        );
    }
    public function getOrder() {
        return 8;
    }
}