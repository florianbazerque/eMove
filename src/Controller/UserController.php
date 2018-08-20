<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 14:53
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    /**
     *  @Route("/profil/{id}", name="profil")
     */
    public function profilAction(User $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if($user == null){
            throw new \Exception('Cet utilistaeur n\'existe pas');
        }else{
            return $this->render('user/profil.html.twig', ['user' => $user]);
        }
    }

    /**
     *  @Route("/login", name="login")
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
}