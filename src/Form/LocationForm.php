<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 19/07/2018
 * Time: 12:46
 */

namespace App\Form;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\StatusLocation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LocationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'utilisateur',
                'label' => false,
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
            ->add('start_date', DateTimeType::class,[
                'format' => 'dd/MM/yyyy H:mm',
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Debut de la location',
                    'class' => 'form-control start'
                ]
            ])
            ->add('end_date', DateTimeType::class,[
                'format' => 'dd/MM/yyyy H:mm',
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Fin de la location',
                    'class' => 'form-control end'
                ]
            ])
            ->add('return_date', HiddenType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Fin de la location réel',
                    'class' => 'form-control end hidden'
                ],
                'data' => false
            ])
        ;
    }
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Location::class,
        ));
    }
}