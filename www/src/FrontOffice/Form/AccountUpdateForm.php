<?php

namespace FrontOffice\Form;

use Core\Entity\User;
use Core\Validator\Constraints\EntityNotExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccountUpdateForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Nom', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Prenom', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Téléphone', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Adresse', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('companyName', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Entreprise', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ;
    }
}
