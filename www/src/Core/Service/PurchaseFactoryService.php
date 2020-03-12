<?php
namespace Core\Service;

use FrontOffice\Entity\Purchase;
use FrontOffice\Entity\PurchaseItem;
use FrontOffice\Entity\Basket;
use Core\Entity\User;
use Core\Repository\AddressRepository;

class PurchaseFactoryService
{
    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }
    public function create(Basket $basket, User $user, string $paymentMethod)
    {
        $purchase = new Purchase();
        
        foreach ($basket->getProducts() as $product) {
            $purchase->addPurchasedItem(new PurchaseItem($product, $basket->getQuantity($product)));
        }

        $shippingAddress = $this->addressRepository->findCurrentWithType($user->getId(), 'shipping');

        $totalPrice = $basket->grandTotal();

        $purchase->setBuyer($user)
              ->setShippingAddress($shippingAddress)
              ->setStatus('processing')
              //->setShippingMethod($basket->getShippingMethod())
              ->setTransaction(
                  new \Core\Entity\Transaction(
                      $paymentMethod,
                      $totalPrice
                  )
              );

        return $purchase;
    }
}
