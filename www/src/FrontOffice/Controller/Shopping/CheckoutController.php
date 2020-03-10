<?php
namespace FrontOffice\Controller\Shopping;

use Core\Entity\Address;
use Core\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Form\Shopping\SelectAddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FrontOffice\Entity\Basket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{

    private $basket;

    private $session;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->basket = new Basket($objectManager);
        $this->session = new Session();
    }

    /**
     * @Route("checkout/address", name="checkoutAddress")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
    */
    public function checkoutAddress(Request $req, AddressRepository $addressRepository): Response
    {
        if (!$this->basket->hasProducts()) {
            return $this->redirectToRoute('basket');
        }
        
        $billingAddress = $addressRepository
           ->findCurrentWithType($this->getUser()->getId(), 'billing');
        
        if (null === $billingAddress) {
            $this->addFlash('info', 'Veuillez renseigner une adresse de facturation avant de continuer');
            return $this->redirectToRoute('accountAddress');
        }
    
        $address = $addressRepository
           ->findCurrentWithType($this->getUser()->getId(), 'shipping');
        
        if (null === $address) {
            $this->addFlash('info', 'Veuillez renseigner une adresse de livraison avant de continuer');
            return $this->redirectToRoute('accountAddress');
        }

        $form = $this->createForm(SelectAddressType::class, new Address(), ['user' => $this->getUser()] );
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->session->set('checkout/address', true);

            return $this->redirectToRoute('checkout/shipping');
        }

        return $this->render('front_office/shop/checkout/address.html.twig', [
            'address_form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("checkout/shipping", name="checkoutShipping")
     */
    public function shipping(Request $req)
    {
        if (!$this->session->get('checkout/address')) {
            return $this->redirectToRoute('basket');
        }

        $form = $this->createForm(\FrontOffice\Form\Shopping\ShippingMethodType::class, null);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $shippingMethod = $form->getData()['shippingMethod'];
            
            $this->basket->addShippingMethod($shippingMethod);

            $this->session->set('checkout/shipping', true);

            return $this->redirectToRoute('checkoutSummary');
        }

        return $this->render('front_office/shopping/checkout/shipping.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("checkout/summary", name="checkoutSummary")
     */
    public function summary()
    {
        if (!$this->session->get('checkout/shipping')) {
            return $this->redirectToRoute('basket');
        }
        $this->session->set('checkout/summary', true);

        $products = $this->basket->getProducts();
        $totalPrice = $this->basket->totalPrice($products);
        $vatPrice = $this->basket->vatPrice($this->basket->grandTotal());
        $shippingFee = $this->basket->getShippingMethod()->getFee();
        $grandTotal = $this->basket->grandTotal();
        
        return $this->render('front_office/shop/checkout/summary.html.twig', [
            'products' => $products,
            'total_price' => $totalPrice,
            'shipping_fee' => $shippingFee,
            'vat_price' => $vatPrice,
            'grand_total' => $grandTotal,
        ]);
    }
    
    /**
     * @Route("checkout/payment", name="checkoutPayment")
     */
    public function payment()
    {
        if (!$this->session->get('checkout/summary')) {
            return $this->redirectToRoute('basket');
        }
        $this->session->set('checkout/payment', true);

        return $this->render('front_office/shop/checkout/payment.html.twig', [
            'total_price' => $this->basket->grandTotal(),
        ]);
    }
}
