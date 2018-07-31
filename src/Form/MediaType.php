<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\MediaCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('path')
            ->add('category', EntityType::class, [
                'class' => MediaCategories::class,
                'choice_label' => 'name'
            ])
            ->add('sContent')
            ->add('autor', HiddenType::class, ['required' => false])
            ->add('thumb', HiddenType::class, ['required' => false])
            ->add('sectionSiteId', HiddenType::class, ['required' => false])
            //->add('create_date')
            //->add('update_date')
            ->add('active', HiddenType::class, ['data' => 1])
            ->add('deleted', HiddenType::class, ['data' => 0])
            ->add('sorting', HiddenType::class, ['data' => 0])
            ->add('image')
            ->add('uploadPath')
            ->add('description')
            ->add('contentHtml')
            //->add('fullPath')
            //->add('metaTitle')
            //->add('metaKeywords')
            //->add('metaDescription')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
