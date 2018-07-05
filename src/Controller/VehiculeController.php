<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 10:56
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{
    /**
     *  @Route("/shop", name="shop")
     */
    public function listAction()
    {
        return $this->render('default/shop.html.twig');
    }

    /**
     *  @Route("/produit", name="produit")
     */
    public function vehiculeAction()
    {
        return $this->render('default/produit.html.twig');
    }
}