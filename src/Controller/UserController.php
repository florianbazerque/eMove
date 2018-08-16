<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 14:53
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     *  @Route("/profil", name="profil")
     */
    public function profilAction()
    {
        return $this->render('user/profil.html.twig');
    }
}