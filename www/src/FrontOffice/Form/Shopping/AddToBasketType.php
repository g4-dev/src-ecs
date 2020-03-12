<?php


namespace FrontOffice\Form\Shopping;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToBasketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('quantity', IntegerType::class, [
              'attr' => ['class' => 'quantity-input'],
              'row_attr' => ['class' => 'v-hide'],
              'empty_data' => 1
           ])
           ->add('product_id', HiddenType::class, [
              'empty_data' => $options['product_id']
           ])
           // TODO: dynamic options
           //->add('trackingNumber', TextType::class);
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => null,
           'csrf_protection' => false,
           'csrf_field_name' => '_token',
           'csrf_token_id'   => 'task_item',
           'product_id' => 0
        ]);
    
        $resolver->setAllowedTypes('product_id', 'integer');
    }
}