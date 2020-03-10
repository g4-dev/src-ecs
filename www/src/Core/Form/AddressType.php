<?php
namespace Core\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Core\Entity\Address;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'firstName' ])
            ->add('lastName', TextType::class, ['label' => 'lastName' ])
            ->add('address', TextType::class)
            ->add('addressComplement', TextType::class, [
               'required' => false
            ])
            ->add('postCode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', TextType::class)
            ->add('phoneNumber', TelType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class
        ]);
    }
}
