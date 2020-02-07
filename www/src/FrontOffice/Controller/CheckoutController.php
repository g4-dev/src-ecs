<?php
namespace FrontOffice\Controller;

use Core\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FrontOffice\Entity\Basket;
use FrontOffice\Form\AddressForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    private $config;

    private $basket;

    private $session;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->basket = new Basket($objectManager);
        $this->session = new Session();
    }

    /**
    * @Route("/checkout/payment", name="checkout/payment")
    */
    public function address(Request $req, AddressRepository $addressRepository)
    {
        if (!$this->basket->hasProducts()) {
            return $this->redirectToRoute('fo_basket');
        }
        try {
            $billingAddress = $addressRepository
                ->findCurrentWithType($this->getUser()->getId(), 'billing');
            $this->addFlash('info', 'Veuillez renseigner une adresse de facturation avant de continuer');
            return $this->redirectToRoute('fo_account');
        }catch (\Exception $e){
            return new Response($e->getMessage(),400);
        }


        $address = $addressRepository
            ->findCurrentWithType($this->getUser()->getId(), 'shipping');
        $form = $this->createForm(AddressForm::class, $address);
        
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
           
            $uow = $this->getDoctrine()
                ->getManager()
                ->getUnitOfWork();
            $uow->computeChangeSets();

            if ($uow->isEntityScheduled($address)) {
                $address = clone $address;
                $address->setDateCreated(new \DateTime());
            }

            $address->setType('shipping')
                    ->setCountry('France')
                    ->setUser($this->getUser());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            $this->session->set('checkout/address', true);

            return $this->redirectToRoute('checkout/shipping');
        }

        return $this->render('shop/checkout/address.html.twig', [
            'address_form' => $form->createView(),
        ]);
    }

    public function shipping(Request $req)
    {
        if (!$this->session->get('checkout/address')) {
            return $this->redirectToRoute('basket_show');
        }

        $form = $this->createForm(\App\Form\ShippingMethodForm::class, null);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $shippingMethod = $form->getData()['shippingMethod'];
            
            $this->basket->addShippingMethod($shippingMethod);

            $this->session->set('checkout/shipping', true);

            return $this->redirectToRoute('checkout_summary');
        }

        return $this->render('shop/checkout/shipping.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function summary()
    {
        if (!$this->session->get('checkout/shipping')) {
            return $this->redirectToRoute('basket_show');
        }
        $this->session->set('checkout/summary', true);

        $products = $this->basket->getProducts();
        $totalPrice = $this->basket->totalPrice($products);
        $vatPrice = $this->basket->vatPrice($this->basket->grandTotal());
        $shippingFee = $this->basket->getShippingMethod()->getFee();
        $grandTotal = $this->basket->grandTotal();
        
        return $this->render('shop/checkout/summary.html.twig', [
            'products' => $products,
            'total_price' => $totalPrice,
            'shipping_fee' => $shippingFee,
            'vat_price' => $vatPrice,
            'grand_total' => $grandTotal,
        ]);
    }

    public function payment()
    {
        if (!$this->session->get('checkout/summary')) {
            return $this->redirectToRoute('basket_show');
        }
        $this->session->set('checkout/payment', true);

        return $this->render('shop/checkout/payment.html.twig', [
            'stripe_pk' => $this->stripePk,
            'total_price' => $this->basket->grandTotal(),
        ]);
    }
}
