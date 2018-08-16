<?php
/**
 * Created by PhpStorm.
 * User: femmanuel
 * Date: 13/07/2018
 * Time: 11:12
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class VehiculeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option){
        $builder
            ->add('modele',TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Recherche',
                    'class' => 'form-control-plaintext'
                )))
            ->add('Ok',SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-outline-warning btn-sm'
                )
            ));
    }

}