<?php

namespace FrontOffice\Form\Shopping;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SelectAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'] ?? null;
        $addresses = $user ? $user->getAddresses() : null;
    
        if ($addresses) {
            $builder->add('addressBilling', ChoiceType::class, [
               'placeholder' => 'Where exactly?',
               'choices' => $user->getAddresses() ,
               'required' => false,
            ]);
        }
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => null,
           'user' => null,
        ]);
    
        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('user', 'object');
    }
}