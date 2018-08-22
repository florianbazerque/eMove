<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 22/08/2018
 * Time: 21:48
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class LocationUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startDate', DateType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Date de début']])
            ->add('endDate', DateType::class, ['attr'=> ['class' => 'form-control', 'placeholder' => 'Date de fin']])
            ->add('submit', SubmitType::class, ['label' => 'Modifier la livraison', 'attr' => ['class' => 'btn btn-primary btn-block']]);
    }
}