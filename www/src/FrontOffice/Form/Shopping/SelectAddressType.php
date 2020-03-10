<?php

namespace FrontOffice\Form\Shopping;

use Core\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Entity\ShippingMethod;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;


class SelectAddressType extends AbstractType
{
    private $objectManager;
    
    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $addresses = $options['addresses'];
    
        if ($addresses) {
            $builder->add('address', EntityType::class, [
               'class' => Address::class,
               'placeholder' => 'Choisissez une adresse',
               'choices' => $addresses,
               'choice_label' => function (Address $address) {
                   return $address->__toString();
               },
               'required' => true,
               'multiple' => false,
               'expanded' => true
            ]);
        }
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => null,
           'addresses' => null,
        ]);
    
        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('addresses', 'array');
    }
}