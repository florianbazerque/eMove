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

class IndexController
{
    /*
     *  @Route("/", name="home_page")
     */
    public function index()
    {
        return new Response(
            '<html><body>Hola quetal</body></html>'
        );
    }

}