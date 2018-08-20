<?php

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
        //password encoder
        //$encoded = $passwordEncoder->encodePassword($user, 'tata');
        $user->setPassword('tata');
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