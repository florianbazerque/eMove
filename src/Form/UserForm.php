<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 16/08/2018
 * Time: 12:46
 */

namespace App\Form;

use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\StatusLocation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('telnum', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Telephone'
                ]
            ])
            ->add('birthdate', DateTimeType::class,[
                'format' => 'dd/MM/yyyy H:mm',
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Fin de la location',
                    'class' => 'form-control birthday'
                ]
            ])
        ;
    }
}