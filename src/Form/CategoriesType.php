<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', HiddenType::class)
            ->add('name', TextType::class, ['label' => 'Наименование'])
//            ->add('create_date', HiddenType::class)
//            ->add('update_date', HiddenType::class)
//            ->add('uploadPath', TextType::class)
            ->add('description', TextareaType::class, ['label' => 'Описание'])
//            ->add('contentHtml', TextareaType::class)
//            ->add('path', TextType::class)
//            ->add('fullPath', TextType::class)
            ->add('metaTitle', TextType::class)
            ->add('metaKeywords', TextType::class)
            ->add('metaDescription', TextareaType::class)
            ->add('active', CheckboxType::class, ['data' => true])
            ->add('deleted', CheckboxType::class, ['data' => false, 'value' => 0, 'required' => false])
            ->add('sorting', NumberType::class, ['data' => 0])
            ->add('parent', EntityType::class, [
                'required' => false,
                'empty_data' => null,
                'placeholder' => 'Каталог',
                'class' => Categories::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
