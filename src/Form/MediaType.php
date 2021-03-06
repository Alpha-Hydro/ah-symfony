<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\MediaCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('imageUpload', FileType::class, [
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => MediaCategories::class,
                'choice_label' => 'name',
                'label' => 'Категория'
            ])
            ->add('name', TextType::class, ['label' => 'Заголовок'])
            //->add('path')
            ->add('sContent', TextareaType::class, [
                'label' => 'Краткое описание',
                'attr' => ['rows' => 4],
            ])
            /* ->add('description', TextareaType::class, [
                 'label' => 'Описание'
             ])*/
            ->add('contentHtml', TextareaType::class, [
                'label' => 'Текст на странице (HTML)',
                'attr' => ['rows' => 12],
            ])
            ->add('active', HiddenType::class, ['data' => 1])
            ->add('deleted', HiddenType::class, ['data' => 0])
            ->add('sorting', HiddenType::class, ['data' => 0])
            ->add('update_date', DateType::class, [
                'label' => 'Дата',
                'widget' => 'single_text',
                'data' => new \DateTime('now')
            ])
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
