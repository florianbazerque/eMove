<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 15:30
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    /**
     *  @Route("/location", name="location")
     */
    public function locationAction()
    {
        return $this->render('user/location.html.twig');
    }

    /**
     *  @Route("/facture", name="facture")
     */
    public function factureAction()
    {
        return $this->render('user/facture.html.twig');
    }
}