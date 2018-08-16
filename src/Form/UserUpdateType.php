<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 12/08/2018
 * Time: 14:05
 */

namespace App\Form;


use App\Entity\TypeUser;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUpdateType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Nom']])
            ->add('lastname', TextType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Prénom']])
            ->add('typeUser', EntityType::class, ['class' => TypeUser::class, 'choice_label' => 'label', 'attr' => ['class' => 'form-control custom-select']])
            ->add('email', EmailType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Votre email']])
            ->add('birthDate', DateType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'DD/MM/YYYY'], 'widget' => 'single_text', 'format' =>  'dd/MM/yyyy'])
            ->add('adresse', TextType::class, ['attr' => ['class' =>  'form-control', 'placeholder' => 'Adresse']])
            ->add('telNum', TelType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Numéro']])
            ->add('submit', SubmitType::class, ['label' => 'Confirmer l\'utilisateur ', 'attr' => ['class' => 'btn btn-primary btn-lg']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}