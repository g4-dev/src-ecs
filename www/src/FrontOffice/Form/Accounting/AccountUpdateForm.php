<?php

namespace FrontOffice\Form\Accounting;

use Core\Entity\Address;
use Core\Entity\User;
use Core\Validator\Constraints\EntityNotExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('addresses', EntityType::class, [
               'class' => Address::class,
               'required' => true,
                'attr' => ['placeholder' => 'Ajouter une adresse ', 'class' => 'form-control-lg'],
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
