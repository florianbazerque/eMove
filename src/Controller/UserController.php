<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 14:53
 */

namespace App\Controller;

use App\Entity\Message;
use App\Entity\TypeUser;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\PasswordChangeType;
use App\Form\PasswordForm;
use App\Service\Html2Pdf;
use App\Form\UserForm;
use App\Entity\Location;
use App\Form\UserRegisterType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
        $user = $this->getUser();
        $locations = $em->getRepository(Location:: class)
            ->findBy(
                ['user' => $user->getId()],
                ['returnDate' => 'ASC']
            );
        $form_info = $this->createForm(UserForm::class, $user);

        $form_info->handleRequest($request);

        if ($form_info->isSubmitted() && $form_info->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            return $this->render('user/profil.html.twig', [
                'user' => $user,
                'locations' => $locations,
                'form' => $form_info->createView()
            ]);
        } else {
            return $this->render('user/profil.html.twig', [
                'user' => $user,
                'locations' => $locations,
                'form' => $form_info->createView()
            ]);
        }
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function connexion($message = 0, AuthenticationUtils $authenticationUtils, Session $session)
    {
        if($message != 0) {
            if($message = 1){
                $session->getFlashBag()->add('success', 'Votre mot de passe a été réinitialisé');
            } else {
                $session->getFlashBag()->add('error', 'Echec de la réinitialisation de votre mot de passe');
            }
        }
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
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $type = new TypeUser();
        $type = $em->getRepository(TypeUser:: class)
            ->findOneBy(
                ['label' => 'Utilisateur']
            );
        $form_user_register = $this->createForm(UserRegisterType::class, $user, ['method' => 'post']);
        $form_user_register->handleRequest($request);
        if ($form_user_register->isSubmitted() && $form_user_register->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setTypeUser($type);
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
     * @Route("/password", name="pwd_forget")
     */
    public function forgetPassword(Request $request,\Swift_Mailer $mailer, Session $session)
    {
        // creates a task and gives it some dummy data for this example
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class, array('label' => 'Réinitialiser'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();
            $user = $em->getRepository(User:: class)
                ->findOneBy(
                    ['email' => $user->getEmail()]
                );
            if($user)
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $random = '';
                for ($i = 0; $i < 11; $i++) {
                    $random .= $characters[rand(0, $charactersLength - 1)];
                }

                $newPwd = password_hash($random, PASSWORD_DEFAULT);
                $user->setPassword($newPwd);
                $em->persist($user);
                $em->flush();

                $mail = (new \Swift_Message('eMove : Réinitialisation de votre mot de passe'))
                    ->setFrom('assy.adon@gmail.com')
                    ->setTo('assy.adon@gmail.com')
                    ->setBody(
                        $this->renderView('contact/contact-new-password.html.twig', ['message' => $random]),
                        'text/html'
                    );

                $mailer->send($mail);
                //return $this->redirectToRoute('task_success');
                return $this->redirectToRoute('login');

            } else {
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('layout/modal_password.html.twig', array(
            'form' => $form->createView(),
        ));
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


    /**
     * @Route("/change-password", name="change_password")
     */
    public function changePasswordAction(Request $request, Session $session, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $locations = $em->getRepository(Location::class)->findBy(['user' => $user->getId()], ['returnDate' => 'ASC']);

        $form_change_password = $this->createForm(PasswordChangeType::class, $user, ['method' => 'post']);

        $form_change_password->handleRequest($request);
        if ($form_change_password->isSubmitted() && $form_change_password->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $session->getFlashBag()->add('success', 'Votre mot de passe a été modifié');

            return $this->redirectToRoute('profil');
        }

        return $this->render('user/password.html.twig', ['form_change_password' => $form_change_password->createView()]);



    }

}