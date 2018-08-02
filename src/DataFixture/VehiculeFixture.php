<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 16:33
 */

namespace App\DataFixture;

use App\Entity\StatusLocation;
use App\Entity\Vehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class VehiculeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $vehicule = new Vehicule();
        $vehicule->setTypeVehicule($this->getReference('typevehicule'));
        $vehicule->setDispoVehicule($this->getReference('dispovehicule'));
        $vehicule->setAgence($this->getReference('agence'));
        $vehicule->setMarque($this->getReference('marque'));
        $vehicule->setNumSerie('AAA111111');
        $vehicule->setModele('Audi A7');
        $vehicule->setCouleur('Noir');
        $vehicule->setPlaqueImma('AAA111111');
        $vehicule->setNbKm('150000');
        $vehicule->setDateAchat(new \DateTime());
        $vehicule->setPrixAchat(60000.50);
        $vehicule->setImage('img/voiture/Audi/A7/1.jpg');
        $vehicule->setDescription('Sed tamen haec cum ita tutius observentur, 
        quidam vigore artuum inminuto rogati ad nuptias ubi aurum dextris manibus 
        cavatis offertur, inpigre vel usque Spoletium pergunt. haec nobilium sunt instituta.');
        $manager->persist($vehicule);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TypeVehiculeFixture::class,
            AgenceFixture::class,
            DispoVehiculeFixture::class,
            MarqueFixture::class
        );
    }
    public function getOrder() {
        return 7;
    }

}