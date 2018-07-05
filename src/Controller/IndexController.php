<?php
/**
 * Created by PhpStorm.
 * User: shuns
 * Date: 04/07/2018
 * Time: 10:05
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     *  @Route("/", name="home_page")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}