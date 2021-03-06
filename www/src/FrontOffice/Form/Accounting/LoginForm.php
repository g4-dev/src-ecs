<?php

namespace FrontOffice\Form\Accounting;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                '_username',
                TextType::class,
                [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Email"
                ]
                ]
            )
            ->add(
                '_password',
                PasswordType::class,
                [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Mot de passe"
                ]

                ]
            )
            ->add('_target_path', HiddenType::class);
    }
}
