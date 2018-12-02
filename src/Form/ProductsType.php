<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'class' => Categories::class,
                'choice_label' => 'name',
            ])
            //name
            ->add('name', TextType::class, [
                'label' => 'Наименование'
            ])
            ->add('sku', TextType::class, [
                'label' => 'Артикул'
            ])
            //description
//            ->add('note')
            ->add('description', TextareaType::class, [
                'label' => 'Краткое описание (Text)',
                'required' => false
            ])
//            ->add('contentHtml')

            //path
//            ->add('fullPath')
//            ->add('path')

            //SEO
            ->add('metaTitle', TextType::class, [
                'required' => false
            ])
            ->add('metaKeywords', TextType::class, [
                'required' => false
            ])
            ->add('metaDescription', TextareaType::class, [
                'required' => false
            ])
            //search
            ->add('sName')
            //checkbox
//            ->add('active')
//            ->add('deleted')
            ->add('sorting', NumberType::class, [
                'label' => 'Сортировка',
                'empty_data' => 0
            ])
            //image && draft
            ->add('imageUpload', FileType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('draftUpload', FileType::class, [
                'required' => false,
            ])
//            ->add('fileImage')
//            ->add('fileDraft')
//            ->add('image')
//            ->add('uploadPath')
//            ->add('draft')
//            ->add('uploadPathDraft')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
