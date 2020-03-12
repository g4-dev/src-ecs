<?php


namespace FrontOffice\Form\Shopping;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToBasketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('quantity', IntegerType::class, [
              'attr' => ['class' => 'quantity-input'],
              'row_attr' => ['class' => 'v-hide']
           ])
           // TODO: dynamic options
           //->add('trackingNumber', TextType::class);
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => null,
           'empty_data' => 'John Doe',
        ]);
    
        //$resolver->setAllowedTypes('price', 'float');
    }
}