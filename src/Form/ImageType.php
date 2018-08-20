<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 19/08/2018
 * Time: 12:53
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, ['label' => 'image du vehicule'])
                ->add('alt', null, ['label' => 'alt de l\'image à inserer']);
    }
}