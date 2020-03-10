<?php

namespace FrontOffice\Form\Shopping;

use Core\Entity\Address;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SelectAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('billingAddress', EntityType::class, [
              'class' => Address::class,
              'choice_label' => 'Choisir une addresse',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('a')
                     ->where('a.type = '. Address::TYPE_BILLING)
                     //->andWhere('a.user_id =' . $this->security->getUser()->getId());
              },
           ])
           ->add('shippingAddress', EntityType::class, [
              'class' => Address::class,
              'choice_label' => 'Choisir une addresse',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('a')
                     ->where('a.type = '. Address::TYPE_SHIPPING)
                     //->andWhere('a.user_id =' . $this->security->getUser()->getId());
              },
           ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => null
        ]);
    }
}