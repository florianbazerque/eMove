<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 16:33
 */

namespace App\DataFixture;

use App\Entity\Vehicule;
use App\Entity\TypeVehicule;
use App\Entity\DispoVehicule;
use App\Entity\Agence;
use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VehiculeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $vehicule = new Vehicule();
        $vehicule->setTypeVehicule((new TypeVehicule())->setLabel("Voiture"));
        $vehicule->setDispoVehicule((new DispoVehicule())->setLabel("Disponible"));
        $vehicule->setAgence((new Agence())->setLabel("Paris"));
        $vehicule->setMarque((new Marque())->setLabel("Citroen"));
        $vehicule->setNumSerie('AAA111111');
        $vehicule->setModele('Audi A7');
        $vehicule->setCouleur('Noir');
        $vehicule->setPlaqueImma('AAA111111');
        $vehicule->setNbKm('150000');
        $vehicule->setDateAchat(new \DateTime());
        $vehicule->setPrixAchat(60000.50);
        //$vehicule->setImage('img/voiture/audiA7/1.jpg');
        $vehicule->setImage('img/voiture/audiA7/1.jpg');
        $manager->persist($vehicule);



        $manager->flush();
    }

}