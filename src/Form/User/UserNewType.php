<?php
/**
 * Created by Alpha-Hydro.
 * @link http://www.alpha-hydro.com
 * @author Vladimir Mikhaylov <admin@alpha-hydro.com>
 * @copyright Copyright (c) 2018, Alpha-Hydro
 *
 */

namespace App\Form\User;


use App\Entity\User;
use App\Entity\UserRoles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class, ['label' => 'Имя, Фамилия'])
            ->add('phone', TextType::class, ['label' => 'Телефон', 'required' => false])
            ->add('address', TextType::class, ['label' => 'Адрес', 'required' => false])
            ->add('active', HiddenType::class, ['data' => 1])
            ->add('deleted', HiddenType::class, ['data' => 0])
            ->add('sorting', HiddenType::class, ['data' => 0])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повтор Пароля'),
            ))
            ->add('userRoles', EntityType::class, [
                'class' => UserRoles::class,
                'choice_label' => 'name',
                'label' => 'Права доступа'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}