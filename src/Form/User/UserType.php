<?php

namespace App\Form\User;

use App\Entity\User;
use App\Entity\UserRoles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('phone', TextType::class, ['label' => 'Телефон', 'required' => false])
            ->add('address', TextType::class, ['label' => 'Адрес', 'required' => false])
            //->add('password')
            ->add('name', TextType::class, ['label' => 'Имя, Фамилия'])
            /*->add('create_date', HiddenType::class)
            ->add('update_date', HiddenType::class)*/
            ->add('active', HiddenType::class, ['data' => 1])
            ->add('deleted', HiddenType::class, ['data' => 0])
            ->add('sorting', HiddenType::class, ['data' => 0])
            ->add('userRoles', EntityType::class, [
                'class' => UserRoles::class,
                'choice_label' => 'name',
                'label' => 'Права доступа'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
