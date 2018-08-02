<?php
/**
 * Created by PhpStorm.
 * User: silve
 * Date: 05/07/2018
 * Time: 10:56
 */

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\TypeVehicule;
use App\Entity\Vehicule;
use App\Form\VehiculeForm;
use App\Manager\VehiculeManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{

    /**
     *  @Route("/shop", name="shop")
     */
    public function listAction()
    {

        $em = $this->getDoctrine()->getManager();
        $vehicules = $em->getRepository(Vehicule:: class)
            ->findBy(
                ['dispoVehicule' => 1],
                ['dateAchat' => 'ASC']
            );
        $promo = true;

        return $this->render('default/shop.html.twig', [
            'vehicules' => $vehicules,
            'promo' => $promo
        ]);
    }

    /**
     *  @Route("/produit/{id}", name="produit_view", requirements={"id"="\d+"})
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehicule = $em->getRepository(Vehicule:: class)
            ->findOneBy(
                ['id' => $id ,'dispoVehicule' => 1]
            );
        $options = $em->getRepository(Vehicule:: class)
            ->findByNot('id', $id);
        if (!$vehicule) {
            throw $this->createNotFoundException(
                'Vehicule absent'
            );
        }elseif ($vehicule == null){
            throw new HttpException(400, "New comment is not valid.");
        } else {
            return $this->render('default/produit.html.twig', [
                'vehicule' => $vehicule,
                'options' => $options
            ]);
        }
    }

    /**
     *  @Route("/produit", name="produit_error")
     */
    public function errorAction()
    {
        throw new HttpException(400, "Aucune voiture selectionner");
    }



/*************************************************************************/
/***************************** FILTER & SEARCH ***************************:
/*************************************************************************/

    /**
     * @Route("search", name="search")
     * @param Request $request
     * @param VehiculeManager $vehiculeManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchVehicule(Request $request, VehiculeManager $vehiculeManager)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $request->request->get('form')['modele'];
        $vehicules = $vehiculeManager->search($search);
        return $this->render('default/shop.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

    /**
     * @Route("filter", name="filter")
     * @param Request $request
     * @param VehiculeManager $vehiculeManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filterVehicule(Request $request, VehiculeManager $vehiculeManager)
    {
        $agence = "";
        $type = "";
        $km_min = "";
        $km_max = "";
        $price_min = "";
        $price_max = "";
        $color = "";
        if ( isset($request->request->get('form')['agence']))
            $agence = $request->request->get('form')['agence'];
        if ( isset($request->request->get('form')['vehicule']))
            $type = $request->request->get('form')['vehicule'];
        if ( isset($request->request->get('form')['Km_Min']))
            $km_min = (int)$request->request->get('form')['Km_Min'];
        if ( isset($request->request->get('form')['Km_Max']))
            $km_max = (int)$request->request->get('form')['Km_Max'];
        if ( isset($request->request->get('form')['Price_Min']))
            $price_min = (int)$request->request->get('form')['Price_Min'];
        if ( isset($request->request->get('form')['Price_Max']))
            $price_max = (int)$request->request->get('form')['Price_Max'];
        if ( isset($request->request->get('form')['couleur']))
            $color = $request->request->get('form')['couleur'];
        $vehicules = $vehiculeManager->filter($agence, $type, $km_min, $km_max, $price_max, $price_min, $color);
        return $this->render('default/shop.html.twig', [
            'vehicules' => $vehicules
        ]);
    }


    /**
     * @return Response
     */
    public function searchBarAction()
    {
        $form = $this->createFormBuilder()
            ->add('modele',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Recherche',
                    'class' => 'form-control-plaintext'
                )))
            ->add('Ok',SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-outline-warning btn-sm'
                )
            ))
            ->setAction($this->generateUrl('search'))
            ->getForm();
        return $this->render('layout/search-bar.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @return Response
     */
    public function filterColAction()
    {
        $agence_tab = ['Paris' => 1, 'Lyon' => 2];
        $vehicule_tab = ['Voiture' => 1, 'Scooter' => 2];
        $color_tab = [
            'Blanc' => 'Blanc',
            'Noir' => 'Noir',
            'Gris' => 'Gris',
            'Beige' => 'Beige',
            'Marron' => 'Marron',
            'Bleu' => 'Bleu',
            'Rouge' => 'Rouge',
            'Jaune' => 'Jaune',
            'Vert' => 'Vert',
            'Rose' => 'Rose',
        ];
        $form = $this->createFormBuilder()
            ->add('agence', ChoiceType::class, [
                'label' => false,
                'choices' => $agence_tab,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'empty_data' => null,

            ])
            ->add('vehicule', ChoiceType::class, [
                'label' => false,
                'choices' => $vehicule_tab,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'empty_data' => null
            ])
            ->add('Km_Min',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Min',
                    'class' => 'form-control checkbox-inline',
                ),
                'required' => false,
                'empty_data' => null
            ))
            ->add('Km_Max',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Max',
                    'class' => 'form-control checkbox-inline'
                ),
                'required' => false,
                'empty_data' => null
            ))
            ->add('Price_Min',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Min',
                    'class' => 'form-control'
                ),
                'required' => false,
                'empty_data' => null
            ))
            ->add('Price_Max',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Max',
                    'class' => 'form-control'
                ),
                'required' => false,
                'empty_data' => null
            ))
            ->add('couleur', ChoiceType::class, [
                'label' => false,
                'choices' => $color_tab,
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('Trier',SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-warning'
                )
            ))
            ->setAction($this->generateUrl('filter'))
            ->getForm();
        return $this->render('layout/filter.html.twig', [
            'form' => $form->createView()
        ]);
    }





}