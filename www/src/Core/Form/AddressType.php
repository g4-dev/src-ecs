<?php
namespace Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Core\Entity\Address;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'Prénom' ,'attr' => [
                'placeholder' => "Prénom"
                ]
            ])
            ->add('lastName', TextType::class, ['label' => 'Nom', 'attr' => [
                'placeholder' => "Nom"
                ]
            ])
            ->add('address', TextType::class, ['label' => 'Adresse', 'attr' => [
                'placeholder' => "Adresse"
                ]
            ])
            ->add('addressComplement', TextType::class, ['label' => 'Complément d\'adresse', 'attr' => [
                'placeholder' => "Complément d'adresse"
                ]
            ])
            ->add('postCode', NumberType::class, ['label' => 'Code postal', 'attr' => [
                'placeholder' => "Code postal"
                ]
            ])
            ->add('city', TextType::class, ['label' => 'Ville', 'attr' => [
                'placeholder' => "Ville"
            ]])
            ->add('country', TextType::class, ['label' => 'Pays', 'attr' => [
                'placeholder' => "Pays"
            ]])
            ->add('phoneNumber', TelType::class, ['label' => 'Téléphone', 'attr' => [
                'placeholder' => "Téléphone"
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class
        ]);
    }
}
