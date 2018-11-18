<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sku')
            ->add('sName')
            ->add('draft')
            ->add('uploadPathDraft')
            ->add('note')
            ->add('path')
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
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
            ])
            ->add('fileImage')
            ->add('fileDraft');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
