<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 14:53
 */

namespace App\Controller;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\PasswordForm;
use App\Service\Html2Pdf;
use App\Form\UserForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function profilAction(Request $request)
    {
        /*
        Florian
        J'ai commencé à ajouter l'essentiel de la function.
        Tu devras aussi:
            - mettre une condition pour savoir si l'utilisateur est connecté
            - ajouter l'affichages des formulaires en twig et verifier qu'il marche bien
            - ajouter les formulaires sur le template profil
        Fait autant de modif que necessaire
        Le code commence ici
*/
        $em = $this->getDoctrine()->getManager();
        /* $id = $this->getUser()->getId();*/
        $id = 1;
        $userId = $em->getRepository(User:: class)
            ->find($id);
        $locations = $em->getRepository(Location:: class)
            ->findBy(
                ['user' => $id],
                ['returnDate' => 'ASC']
            );
        $user = new User();
        $form_info = $this->createForm(UserForm::class, $user);
        $form_info->handleRequest($request);
        if ($form_info->isSubmitted() && $form_info->isValid()) {
            $task = $form_info->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            return $this->render('user/profil.html.twig', [
                'user' => $userId,
                'locations' => $locations,
                'form' => $form_info->createView()
            ]);
        } else {
            return $this->render('user/profil.html.twig', [
                'user' => $userId,
                'locations' => $locations,
                'form' => $form_info->createView()
            ]);
        }
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('layout/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form_user_register = $this->createForm(UserRegisterType::class, $user, ['method' => 'post']);
        $form_user_register->handleRequest($request);
        if ($form_user_register->isSubmitted() && $form_user_register->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //return $this->render('user/profil.html.twig', ['user' => $user]);
            return $this->redirectToRoute('home_page');
        }
        return $this->render('user/registration.html.twig', ['form_user_register' => $form_user_register->createView()]);
    }

    /**
     * @Route("/pdf?location={id}", name="pdf_profil", requirements={"id"="\d+"})
     */
    public function pdfProfilAction(Location $id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($id);
        if($location){
            $vehicule = $em->getRepository(Vehicule::class)->find($location->getVehicule()->getId());
            $user = $em->getRepository(User::class)->find($location->getUser()->getId());
            $template = $this->renderView('default/pdf.html.twig', ['location' => $location, 'vehicule' => $vehicule, 'user' => $user]);
        }

        $firstname = $user->getFirstName();
        $modele = $vehicule->getModele();
        $name = 'location_'.$firstname.'_'.$modele;
        $html2pdf = new Html2Pdf();
        $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10, 15, 10, 15));
        $html2pdf->generatePdf($template,$name);

    }



}