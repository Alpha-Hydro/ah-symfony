<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CategoriesType
 * @package App\Form
 */
class CategoriesType extends AbstractType
{

    /**
     * @var CategoriesToNumberTransformer
     */
    private $transformer;

    /**
     * CategoriesType constructor.
     * @param CategoriesToNumberTransformer $transformer
     */
    public function __construct(CategoriesToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', HiddenType::class)
            ->add('name', TextType::class, ['label' => 'Наименование категории'])
//            ->add('create_date', HiddenType::class)
//            ->add('update_date', HiddenType::class)
//            ->add('uploadPath', TextType::class)
            ->add('description', TextareaType::class, [
                'label' => 'Описание',
                'required' => false
            ])
//            ->add('contentHtml', TextareaType::class)
//            ->add('path', TextType::class)
//            ->add('fullPath', TextType::class)
            ->add('metaTitle', TextType::class, ['required' => false])
            ->add('metaKeywords', TextType::class, ['required' => false])
            ->add('metaDescription', TextareaType::class, ['required' => false])
            ->add('active', CheckboxType::class, ['label' => 'Активность', 'data' => true])
            ->add('deleted', HiddenType::class, ['data' => 0])
            ->add('sorting', NumberType::class, ['label' => 'Сортировка', 'data' => 0])
            /*->add('parent', EntityType::class, [
                'label' => 'Родительская категория',
                'required' => false,
                'empty_data' => null,
                'placeholder' => 'Каталог',
                'class' => Categories::class,
                'choice_label' => 'name'
            ])*/
            ->add('parent', HiddenType::class, [
                'invalid_message' => 'That is not a valid category id'
            ]);

        $builder->get('parent')
            ->addModelTransformer($this->transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
