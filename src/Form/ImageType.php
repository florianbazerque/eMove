<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 19/08/2018
 * Time: 12:53
 */

namespace App\Form;


use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, ['label' => '  Image à inserer', 'attr' => ['class' => 'form-control btn btn-default btn-file']])
                ->add('alt', null, ['label' => '  alt de l\'image ', 'attr' => ['class' => 'form-control','placeholder' => 'alt de l\'image'] ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}