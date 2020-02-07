<?php
namespace Core\Service;

use FrontOffice\Entity\Order;
use FrontOffice\Entity\OrderProduct;
use FrontOffice\Entity\Basket;
use Core\Entity\User;
use Core\Repository\AddressRepository;

class OrderfactoryService
{
    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }
    public function create(Basket $basket, User $user, string $paymentMethod)
    {
        $order = new Order();
        
        foreach ($basket->getProducts() as $product) {
            $order->addProduct(new OrderProduct($product));
        }

        $shippingAddress = $this->addressRepository->findCurrentWithType($user->getId(), 'shipping');
        $billingAddress = $this->addressRepository->findCurrentWithType($user->getId(), 'billing');
        
        $totalPrice = $basket->grandTotal();

        $order->setUser($user)
              ->setShippingAddress($shippingAddress)
              ->setBillingAddress($billingAddress)
              ->setStatus('processing')
              ->setShippingMethod($basket->getShippingMethod())
              ->setTransaction(
                  new \FrontOffice\Entity\Transaction(
                      $paymentMethod,
                      $totalPrice
                  )
              );

        return $order;
    }
}
