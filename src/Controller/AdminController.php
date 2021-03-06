<?php
/**
 * Created by PhpStorm.
 * <<<<<<< HEAD
 * User: adm
 * Date: 05/07/2018
 * Time: 20:21
 * =======
 * User: silve
 * Date: 05/07/2018
 * Time: 15:14
 * >>>>>>> ac0a254594446bbfe72582b3d8c9c705a20e18ce
 */

namespace App\Controller;

use App\Form\PromoType;
use App\Entity\DispoVehicule;
use App\Entity\Location;
use App\Entity\Message;
use App\Entity\Promo;
use App\Entity\TypeUser;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\Agence;
use App\Form\AgenceType;
use App\Form\LocationUpdateType;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Form\Vehiculetype;
use App\Form\VehiculeUpdateType;
use App\Form\AgenceUpdateType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminController extends AbstractController
{

    //**************** PARTIE INDEX ADMIN

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $vehicules = $em->getRepository(Vehicule::class)->findAll();
        $agences = $em->getRepository(Agence::class)->findAll();
        $messages = $em->getRepository(Message::class)->findAll();
        $locations = $em->getRepository(Location::class)->findAll();
        $promos = $em->getRepository(Promo::class)->findAll();

        //------ Formulaire (user, vehicule, agence)
        $user = new User();
        $form_user = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('add_user'), 'method' => 'POST']);

        $vehicule = new Vehicule();
        $form_vehicule = $this->createForm(Vehiculetype::class, $vehicule, ['action' => $this->generateUrl('add_vehicule'), 'method' => 'POST']);


        $agence = new Agence();
        $form_agence = $this->createForm(AgenceType::class, $agence, ['action' => $this->generateUrl('add_agence'), 'method' => 'POST']);

        $promo = new Promo();
        $form_promo = $this->createForm(PromoType::class, $promo, ['action' => $this->generateUrl('add_promo'), 'method' => 'POST']);

        return $this->render('admin/dashboard.html.twig', ['users' => $users, 'vehicules' => $vehicules, 'agences' => $agences, 'messages' => $messages, 'locations' => $locations, 'promos' => $promos, 'form_user' => $form_user->createView(), 'form_vehicule' => $form_vehicule->createView(), 'form_agence' => $form_agence->createView(), 'form_promo' => $form_promo->createView()]);
    }

    //***************  PARTIE UTILISATEUR


    /**
     * @Route("/dashboard/add-user", name="add_user")
     */

    public function addUserAction(Request $request, Session $session, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $session->getFlashBag()->add('success', 'L\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a été créer');

            return $this->redirectToRoute("dashboard");

        } else {
            //il faudrait recuperer l'erreur et l'afficher
            $session->getFlashBag()->add('error', 'Un des champ n\'est pas valide');
            return $this->redirectToRoute("dashboard");
        }
    }


    /**
     * @Route("/dashboard/update-user/{id}", name="update_user", requirements={"id"="\d+"})
     */

    public function updateUserAction(Request $request, Session $session, User $id)
    {
        //$serialize = new Serializer();

        /*if($request->isXmlHttpRequest()){
            $id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id);
            //$form_user = $this->createForm(UserType::class, $user, ['action' => $this->generateUrl('update_user'), 'method' => 'POST']);
            //return $this->render('admin/dashboard.html.twig', ['id' => $id ]);
            //$json = $serialize->serialize($user, 'json');
            return new Response('test');
        }*/

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        $form_user_update = $this->createForm(UserUpdateType::class, $user, ['method' => 'post']);

        $form_user_update->handleRequest($request);

        if ($form_user_update->isSubmitted() && $form_user_update->isValid()) {

            if ($user) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $session->getFlashBag()->add('success', 'L\'utilisateur ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a été modifié');

                return $this->redirectToRoute("dashboard");
            } else {
                $session->getFlashBag()->add('error', 'Une erreur est survenue');
                return $this->redirectToRoute("dashboard");
            }
        } else {
            return $this->render('admin/layout/update/update-user.html.twig', ['form_update_user' => $form_user_update->createView()]);
        }
    }

    /**
     * @Route("/dashboard/delete-user/{id}", name="delete_user", requirements={"id"="\d+"})
     */
    public function deleteUserAction(User $id, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($id);

        if ($user) {
            $em->remove($user);

            $em->flush();

            $session->getFlashBag()->add('success', 'L\'utilisateur a bien été supprimmer');

            return $this->redirectToRoute("dashboard");
        } else {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');

            return $this->redirectToRoute("dashboard");
        }
    }


    //-------------------    PARTIE VEHICULE

    /**
     * @Route("/dashboard/add-vehicule", name="add_vehicule")
     */
    public function addVehiculeAction(Request $request, Session $session)
    {
        $vehicule = new Vehicule();

        $form = $this->createForm(Vehiculetype::class, $vehicule);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicule);
            $em->flush();

            $session->getFlashBag()->add('success', 'Le vehicule ' . $vehicule->getMarque()->getLabel() . ' de modèle ' . $vehicule->getModele() . ' a été ajouter');

            return $this->redirectToRoute("dashboard");
        } else {
            $session->getFlashBag()->add('error', 'Le vehicule ' . $vehicule->getMarque()->getLabel() . ' de modèle ' . $vehicule->getModele() . ' n\' a pa pu être ajouter');

            return $this->redirectToRoute("dashboard");
        }
    }


    /**
     * @Route("/dashboard/update-vehicule/{id}", name="update_vehicule", requirements={"id"="\d+"})
     */

    public function updateVehiculeAction(Request $request, Session $session, Vehicule $id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule::class)->find($id);

        $form_vehicule_update = $this->createForm(VehiculeUpdateType::class, $vehicule, ['method' => 'post']);

        $form_vehicule_update->handleRequest($request);

        if ($form_vehicule_update->isSubmitted() && $form_vehicule_update->isValid()) {

            if ($vehicule) {
                $em->persist($vehicule);
                $em->flush();

                $session->getFlashBag()->add('success', 'Le vehicule ' . $vehicule->getMarque()->getLabel() . ' de modèle ' . $vehicule->getModele() . ' a été modifié');

                return $this->redirectToRoute("dashboard");
            } else {
                $session->getFlashBag()->add('error', 'Une erreur est survenue');
                return $this->redirectToRoute("dashboard");
            }
        } else {
            return $this->render('admin/layout/update/update-vehicule.html.twig', ['form_vehicule_update' => $form_vehicule_update->createView()]);
        }
    }

    /**
     * @Route("/dashboard/delete-vehicule/{id}", name="delete_vehicule", requirements={"id"="\d+"})
     */

    public function deleteVehiculeAction(Vehicule $id, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $vehicule = $em->getRepository(Vehicule::class)->find($id);

        if ($vehicule) {
            $em->remove($vehicule);

            $em->flush();

            $session->getFlashBag()->add('success', 'Le vehicule a bien été supprimmer');

            return $this->redirectToRoute("dashboard");
        } else {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');

            return $this->redirectToRoute("dashboard");
        }
    }

    //--------------------  AGENCE -----------------

    /**
     * @Route("/dashboard/add-agence", name="add_agence")
     */

    public function addAgenceAction(Request $request, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = new Agence();

        $form = $this->createForm(AgenceType::class, $agence);

        $form->handleRequest($request);

        $agence_exist = $em->getRepository(Agence::class)->findAll();


        if ($form->isValid() && $form->isSubmitted()) {

            foreach ($agence_exist as $exist){
                if($exist->getLabel() == $agence->getLabel()){
                    $session->getFlashBag()->add('error', 'L\'agence ' . $agence->getLabel() . ' existe déjà');

                    return $this->redirectToRoute("dashboard");
                }
            }

            $em->persist($agence);
            $em->flush();

            $session->getFlashBag()->add('success', 'L\'agence ' . $agence->getLabel() . ' a été ajouter');

            return $this->redirectToRoute("dashboard");
        } else {
            $session->getFlashBag()->add('error', 'L\'agence ' . $agence->getLabel() . ' n\'a pas pu être ajouter');

            return $this->redirectToRoute("dashboard");
        }
    }

    /**
     * @Route("/dashboard/update-agence/{id}", name="update_agence", requirements={"id"="\d+"})
     */

    public function updateAgenceAction(Agence $id, Request $request, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = $em->getRepository(Agence::class)->find($id);

        $form_agence_update = $this->createForm(AgenceUpdateType::class, $agence, ['method' => 'post']);

        $form_agence_update->handleRequest($request);

        if($form_agence_update->isSubmitted() && $form_agence_update->isValid()){
            if($agence){
                $em->persist($agence);
                $em->flush();

                $session->getFlashBag()->add('success', 'L\'agence ' . $agence->getLabel() . ' a été modifier');

                return $this->redirectToRoute('dashboard');
            }else{
                $session->getFlashBag()->add('error', 'Une erreur est survenue');

                return $this->redirectToRoute('dashboard');
            }
        }

        return $this->render('admin/layout/update/update-agence.html.twig', ['form_agence_update' => $form_agence_update->createView()]);
    }

    /**
     * @Route("/dashboard/delete-agence/{id}", name="delete_agence", requirements={"id"="\d+"})
     */

    public function deleteAgenceAction(Agence $id, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $agence = $em->getRepository(Agence::class)->find($id);

        if($agence){
            $em->remove($agence);
            $em->flush();

            $session->getFlashBag()->add('success', 'L\' agence a été supprimmer');

            return $this->redirectToRoute('dashboard');
        }else{
            $session->getFlashBag()->add('error', 'Une erreur est survenue');

            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     * @Route("/dashboard/message/{id}", name="admin_message", requirements={"id"="\d+"})
     */

    public function messageAction(Message $id)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Message::class)->find($id);

        if($message && $user){
            return $this->render('admin/layout/admin-message.html.twig', ['message' => $message]);
        } else {
            return $this->$this->redirectToRoute('home_page');
        }
    }

    /**
     * @Route("/dashboard/location-update/{id}", name="location_update", requirements={"id"="\d+"})
     */

    public function updateLocationAction(Location $id, Request $request, Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($id);

        $form_location_update = $this->createForm(LocationUpdateType::class, $location, ['method' => 'post']);

        $form_location_update->handleRequest($request);

        if($form_location_update->isSubmitted() && $form_location_update->isValid()){
            if($location){
                $em->persist($location);
                $em->flush();

                $session->getFlashBag()->add('success', 'La location a été modifier');

                return $this->redirectToRoute('dashboard');
            } else {
                $session->getFlashBag()->add('error', 'La location n\'a pas pu être modifier');

                return $this->redirectToRoute('dashboard');
            }

        }
        return $this->render('admin/layout/update/update-location.html.twig', ['form_location_update' => $form_location_update->createView()]);
    }

    /**
     * @Route("/dashboard/location-delete/{id}", name="location_delete", requirements={"id"="\d+"})
     */

    public function deleteLocationAction(Location $id, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $location = $em->getRepository(Location::class)->find($id);
        $vehicule = $em->getRepository(Vehicule::class)->find($location->getVehicule()->getId());
        $dispoVehicule = $em->getRepository(DispoVehicule::class)->findOneBy(['label' => 'Disponible']);

        if($location){
            $vehicule->setDispoVehicule($dispoVehicule);
            $em->persist($vehicule);
            $em->remove($location);
            $em->flush();

            $session->getFlashBag()->add('success', 'La Location a été supprimmer');

            return $this->redirectToRoute('dashboard');
        }else{
            $session->getFlashBag()->add('error', 'Une erreur est survenue');

            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     *  @Route("/dashboard/add-promo", name="add_promo")
     */

    public function addPromoAction(Request $request, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $promo = new Promo();
        $form = $this->createForm(PromoType::class, $promo);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($promo){
                $em->persist($promo);
                $em->flush();

                $session->getFlashBag()->add('success', 'La promotion a été ajouter');

                return $this->redirectToRoute('dashboard');
            }else{
                $session->getFlashBag()->add('error', 'La promotion n\'a  pas pu être ajouter');

                return $this->redirectToRoute('dashboard');
            }
        }
    }

    /**
     *  @Route("/dashboard/update-promo/{id}", name="update_promo", requirements={"id"="\d+"})
     */

    public function updatePromoAction(Promo $id, Request $request, Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository(Promo::class)->find($id);

        $form_promo_update = $this->createForm(PromoType::class, $promo, ['method' => 'post']);

        $form_promo_update->handleRequest($request);

        if($form_promo_update->isSubmitted() && $form_promo_update->isValid()){
            var_dump('test');die;
            if($promo){
                $em->persist($promo);
                $em->flush();

                $session->getFlashBag()->add('success', 'La promo a été modifier');

                return $this->redirectToRoute('dashboard');
            } else {
                $session->getFlashBag()->add('error', 'La promo n\'a pas pu être modifier');

                return $this->redirectToRoute('dashboard');
            }

        }
        return $this->render('admin/layout/update/update-promo.html.twig', ['form_promo_update' => $form_promo_update->createView()]);
    }

    /**
     * @Route("/dashboard/delete-promo/{id}", name="delete_promo", requirements={"id"="\d+"})
     */

    public function deletePromoAction(Promo $id, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $promo = $em->getRepository(Promo::class)->find($id);

        if($promo){
            $em->remove($promo);
            $em->flush();

            $session->getFlashBag()->add('success', 'La promo a été supprimmer');

            return $this->redirectToRoute('dashboard');
        }else{
            $session->getFlashBag()->add('error', 'Une erreur est survenue');

            return $this->redirectToRoute('dashboard');
        }
    }

    /**
     *  @Route("/retard-location/{id}", name="retard_location", requirements={"id"="\d+"})
     */

    public function retardLocationAction(Location $id, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($id);

        //envoi de l'email de retard de la location au client
        $user = $em->getRepository(User::class)->find($location->getUser()->getId());
        $vehicule = $em->getRepository(Vehicule::class)->find($location->getVehicule()->getId());
        $user_email = $user->getEmail();

        $mail = (new \Swift_Message('Retard Location du vehicule '.$vehicule->getMarque()->getLabel().' '.$vehicule->getModel()))
            ->setFrom('retard@emove.com')
            ->setTo($user_email)
            ->setBody(
                $this->renderView('user/retard-location-mail.html.twig', ['location' => $location, 'vehicule' => $vehicule ,'user' => $user]),
                'text/html'
            );


        $mailer->send($mail);

        return;
    }


}