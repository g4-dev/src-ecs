<?php

namespace FrontOffice\Form\Accounting;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('lastName', TextType::class, [
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
            ->add('companyName', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Entreprise', 'class' => 'form-control-lg'],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('newsLetter', CheckboxType::class, [
                'attr' => ['placeholder' => 'Newsletter'],
            ])
            ;
    }
}
