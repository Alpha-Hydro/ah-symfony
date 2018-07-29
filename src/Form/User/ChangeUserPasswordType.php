<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.07.2018
 * Time: 20:49
 */

namespace App\Form\User;


use App\Entity\ChangeUserPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeUserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class, ['label' => 'Текущий пароль']);
        $builder->add('newPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Повтор введенного пароля не совпадает',
            'required' => true,
            'first_options' => ['label' => 'Новый пароль'],
            'second_options' => ['label' => 'Повторите новый пароль'],
        ]);
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangeUserPassword::class,
        ]);
    }
}