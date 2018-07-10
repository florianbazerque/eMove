<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 10:56
 */

namespace App\Controller;

use App\Entity\Vehicule;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{

    /**
     *  @Route("/shop", name="shop")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $vehicules = $em->getRepository(Vehicule:: class)
            ->findAll();
        return $this->render('default/shop.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

    /**
     *  @Route("/produit/{id}", name="produit_view", requirements={"id"="\d+"})
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule:: class)
            ->find($id);
        if (!$vehicule) {
            throw $this->createNotFoundException(
                'No vehicule found for id '.$id
            );
        }elseif ($vehicule == null){
            throw new HttpException(400, "New comment is not valid.");
        } else {
            return $this->render('default/produit.html.twig', [
                'vehicule' => $vehicule
            ]);
        }
    }

    /**
     *  @Route("/produit", name="produit_error")
     */
    public function errorAction()
    {
        throw new HttpException(400, "Aucune voiture selectionner");
    }

}