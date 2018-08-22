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
use App\Entity\Message;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/contact-confirmation", name="contact")
     */
    public function contactAction(Request $request, Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        $message_admin = new Message();
        $message_admin->setNom($name);
        $message_admin->setDate(new \DateTime());
        $message_admin->setMessage($message);
        $message_admin->setHeure(date('H:i:s'));
        $message_admin->setEmail($email);

        $mail = (new \Swift_Message('Message client'))
            ->setFrom($email)
            ->setTo('assy.adon@gmail.com')
            ->setBody(
                $this->renderView('contact/contact-message.html.twig', ['name' => $name, 'email' => $email, 'message' => $message]),
                'text/html'
            );

        $mailer->send($mail);

        $em->persist($message_admin);
        $em->flush();

        return $this->render('contact/contact-confirmation.html.twig');
    }



    /**
     *  @Route("/error={id}", name="error", requirements={"id"="\d+"})
     */
    public function errorsAction($id)
    {
        switch ($id){

            case 0 :
                $error = "Vehicule indisponible";
                break;
            case 1 :
                $error = "Qui êtes-vous ?";
                break;
            case 2 :
                $error = "Vehicule loue ou resserve";
                break;
            case 3 :
                $error = "Ben alors on es perdu ?";
                break;
            default :
                $error =  "Désolé, une erreur est survenue, page demandée introuvable!";
        }

        return $this->render('default/errors.html.twig', [
            'error' => $error,
        ]);
    }

}