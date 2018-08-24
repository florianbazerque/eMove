<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 23/08/2018
 * Time: 12:11
 */

namespace App\Form;


use App\Entity\Marque;
use App\Entity\Vehicule;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder->add('label', TextType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Nom de l\' offre']])
            ->add('description', TextareaType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Description']])
            ->add('legal_condition', TextType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Condition légal']])
            ->add('vehicule', EntityType::class, ['class' => Vehicule::class, 'choice_label' => 'modele','attr'=> ['class' => 'form-control custom-select']])
            ->add('marque', EntityType::class, ['class' => Marque::class, 'choice_label' => 'label', 'attr' => ['class' =>  'form-control custom-select']])
            ->add('startDate', DateType::class, ['attr' => ['class' =>  'form-control']])
            ->add('endDate', DateType::class, ['attr' => ['class' => 'form-control']])
            ->add('value', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('image',  ImageType::class)
            ->add('submit', SubmitType::class, ['label' => 'Valider l\'offre', 'attr' => ['class' => 'btn btn-primary']]);
    }
}