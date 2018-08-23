<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 15:30
 */

namespace App\Controller;

use App\Entity\DispoVehicule;
use App\Entity\Location;
use App\Entity\Promo;
use App\Entity\StatusLocation;
use App\Entity\Vehicule;
use App\Form\LocationForm;
use App\Entity\User;
use App\Service\FidelityPoint;
use App\Service\Html2Pdf;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints\DateTime;


class LocationController extends AbstractController
{
    /**
     *  @Route("/location/{id}", name="location_view", requirements={"id"="\d+"})
     */
    public function locationAction(Vehicule $id, Request $request, Session $session)
    {

        $em = $this->getDoctrine()->getManager();
        $dispo = $em->getRepository(DispoVehicule:: class)
            ->findOneBy(
                ['label' => 'Disponible']
            );
        $statut = $em->getRepository(StatusLocation:: class)
            ->findOneBy(
                ['label' => 'Retourné']
            );
        $vehicule = $em->getRepository(Vehicule:: class)
            ->findOneBy(
                ['id' => $id ,'dispoVehicule' => $dispo->getId()],
                ['id' => 'ASC']
            );
        $promo_vehicule = $em->getRepository(Promo::class)->currentPromoVehicule();
        $html2pdf = new Html2Pdf();
        $location = new Location();
        $location->setVehicule($vehicule);
        $location->setStatusLocation($statut);
        $location->setReturnKm(null);
        $location->setReturnDate(null);
        $form = $this->createForm(LocationForm::class, $location);
        $form->handleRequest($request);

        if (!$this->getUser())
        {
            return $this->redirectToRoute('login');
        }else {


            if (!$vehicule || $vehicule == null) {
                return $this->redirectToRoute('error', [
                    'id' => 2,
                ]);
            } elseif ($form->isSubmitted() && $form->isValid()) {

                $user = $em->getRepository(User:: class)
                    ->find($this->getUser());
                $statut = $em->getRepository(StatusLocation:: class)
                    ->findOneBy(
                        ['label' => 'En location']);
                $statut2 = $em->getRepository(StatusLocation:: class)
                    ->findOneBy(
                        ['label' => 'Réservé']);

                $loue = $em->getRepository(Location:: class)
                    ->findOneBy(
                        ['statusLocation' => $statut->getId(), 'vehicule' => $id],
                        ['vehicule' => 'ASC']
                    );
                $reserve = $em->getRepository(Location:: class)
                    ->findOneBy(
                        ['statusLocation' => $statut2->getId(), 'vehicule' => $id],
                        ['vehicule' => 'ASC']
                    );
                if (!$loue || !$reserve) {
                    $start = $form["start_date"]->getData();
                    $end = $form["end_date"]->getData();
                    $now = new \DateTime('Now');
                    if ($start >= $end || $now > $start ) {
                        $session->getFlashBag()->add('error', 'Mauvaise saise des dates');
                        return $this->render('user/location.html.twig', [
                            'vehicule' => $vehicule,
                            'promos' => $promo_vehicule,
                            'form' => $form->createView(),
                            'user' => $user
                        ]);
                    } else {
                        $price = new FidelityPoint();
                        $prix = $price->getBuild($start->format('Y-m-d H:i'), $end->format('Y-m-d H:i'), $vehicule->getPrixAchat(), $user->getFidelityPoint());
                        $location->setPrice($prix);
                        $dispo = $em->getRepository(DispoVehicule:: class)
                            ->findOneBy(
                                ['label' => 'Indisponible']
                            );
                        $em = $this->getDoctrine()->getManager();
                        if ($user->getFidelityPoint() >= 100){
                            $point = $user->getFidelityPoint() + $vehicule->getFidelitypoint() - 100;
                            $spend = $user->getSpendPoint() + 100;
                        }else{
                            $point = $user->getFidelityPoint() + $vehicule->getFidelitypoint();
                            $spend = $user->getSpendPoint();
                        }
                        $user->setSpendPoint($spend);
                        $user->setFidelityPoint($point);
                        $vehicule->setDispoVehicule($dispo);
                        $em->persist($location, $vehicule, $user);
                        $em->flush();
                        $em->refresh($location);
                        return $this->redirectToRoute('facture', [
                            'id' => $location->getId(),
                        ]);
                    }
                } else {
                    return $this->redirectToRoute('error', [
                        'id' => 2,
                    ]);
                }
            } else {
                $user = $em->getRepository(User:: class)
                    ->find($this->getUser());
                return $this->render('user/location.html.twig', [
                    'vehicule' => $vehicule,
                    'promos' => $promo_vehicule,
                    'form' => $form->createView(),
                    'user' => $user
                ]);
            }
        }
    }




    /**
     *  @Route("/facture?vehicule={id}", name="facture", requirements={"id"="\d+"})
     */
    public function factureAction($id, Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location:: class)
            ->find($id);
        if (!$location) {
            throw $this->createNotFoundException(
                'Location indisponible'.$id
            );
        }elseif ($location == null){
            return $this->redirectToRoute('error', [
                'id' => 0,
            ]);
        } else {
            $vehicule = $em->getRepository(Vehicule::class)
                ->find($location->getVehicule());


            //envoi de l'email de confirmation au client
            $user = $this->getUser();
            $user_email = $user->getEmail();

            $mail = (new \Swift_Message('Message client'))
                ->setFrom('facture@emove.com')
                ->setTo('assy.adon@gmail.com')
                ->setBody(
                    $this->renderView('user/location-confirmation-mail.html.twig', ['location' => $location, 'vehicule' => $vehicule ,'user' => $user]),
                    'text/html'
                );


            $mailer->send($mail);
            return $this->render('user/facture.html.twig', [
                'location' => $location,
                'vehicule' => $vehicule

            ]);
        }
    }

    /**
     *  @Route("/pdf?location={id}", name="pdf", requirements={"id"="\d+"})
     *  @return Response
     */
    public function PdfAction(Location $id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location:: class)
            ->find($id);
        if (!$location) {
            throw $this->createNotFoundException(
                'Location indisponible'
            );
        }elseif ($location == null){
            return $this->redirectToRoute('error', [
                'id' => 0,
            ]);
        } else {
            $user = $em->getRepository(User::class)
                ->find($location->getUser());
            $vehicule = $em->getRepository(Vehicule::class)
                ->find($location->getVehicule());
            $template = $this->renderview('default/pdf.html.twig', array(
                'location' => $location,
                'vehicule' => $vehicule,
                'user' => $user
            ));
            $firstname =$user->getfirstname();
            $modele = $vehicule->getModele();
            $name = 'location_'.$firstname.'_'.$modele;
            $html2pdf = new Html2Pdf();
            $html2pdf->create('P', 'A4', 'fr', true, 'UTF-8', array(10, 15, 10, 15));
            return $html2pdf->generatePdf($template, $name);
        }
    }
}