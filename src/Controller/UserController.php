<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 14:53
 */

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @Route("/password", name="pwd_forget")
     */
    public function forgetPassword(Request $request,\Swift_Mailer $mailer)
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
                $random = random_bytes(10);
                $newPwd = password_hash($random, PASSWORD_DEFAULT);
                $user->setPassword($newPwd);
                $em->persist($user);
                $em->flush();

                $mail = (new \Swift_Message('eMove : Réinitialisation de votre mot de passe'))
                    ->setFrom('bazerquef@gmail.com')
                    ->setTo('florian.bazerque@orange.fr')
                    ->setBody(
                        $this->renderView('contact/contact-new-password.html.twig', ['message' => $random]),
                        'text/html'
                    );

                $mailer->send($mail);
                return $this->redirectToRoute('task_success');

            } else {
                return $this->redirectToRoute('task_error');
            }
        }

        return $this->render('layout/modal_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}