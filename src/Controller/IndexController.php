<?php
/**
 * Created by PhpStorm.
 * User: shuns
 * Date: 04/07/2018
 * Time: 10:05
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Swift_Mailer;

class IndexController extends AbstractController
{
    /**
     *  @Route("/", name="home_page")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     *  @Route("/contact-confirmation", name="contact")
     */
    public function contactAction(Request $request , Swift_Mailer $mailer){
       $name = $request->request->get('name');
       $email = $request->request->get('email');
       $message = $request->request->get('message');

       $mail = (new \Swift_Message('Message client'))
           ->setFrom($email)
           ->setTo('assy.adon@gmail.com')
           ->setBody(
               $this->renderView('contact/contact-message.html.twig', ['name' => $name, 'email' => $email, 'message' => $message]),
               'text/html'
           );

       //var_dump($mail);die;
       $mailer->send($mail);

       return $this->render('contact/contact-confirmation.html.twig');
    }
}