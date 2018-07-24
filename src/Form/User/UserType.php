<?php

namespace App\Form\User;

use App\Entity\User;
use App\Entity\UserRoles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('phone', TextType::class)
            ->add('address', TextType::class)
            //->add('password')
            ->add('name', TextType::class)
            /*->add('create_date', HiddenType::class)
            ->add('update_date', HiddenType::class)*/
            ->add('active', CheckboxType::class)
            //->add('deleted', CheckboxType::class)
            //->add('sorting', TextType::class)
            ->add('userRoles', EntityType::class, [
                'class' => UserRoles::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
