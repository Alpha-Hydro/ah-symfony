<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path')
            ->add('sContent')
            ->add('autor')
            ->add('thumb')
            ->add('sectionSiteId')
            ->add('name')
            ->add('create_date')
            ->add('update_date')
            ->add('active')
            ->add('deleted')
            ->add('sorting')
            ->add('image')
            ->add('uploadPath')
            ->add('description')
            ->add('contentHtml')
            ->add('fullPath')
            ->add('metaTitle')
            ->add('metaKeywords')
            ->add('metaDescription')
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
