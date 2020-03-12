<?php
namespace FrontOffice\Controller\Shopping;

use Core\Entity\Address;
use Core\Form\AddressType;
use Core\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Form\Shopping\SelectAddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FrontOffice\Entity\Basket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class CheckoutController extends AbstractController
{

    private $basket;

    private $session;
    
    private $translator;

    public function __construct(EntityManagerInterface $objectManager, TranslatorInterface $translator)
    {
        $this->basket = new Basket($objectManager);
        $this->session = new Session();
        $this->translator = $translator;
    }

    /**
     * @Route("checkout/address", name="checkoutAddress")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
    */
    public function checkoutAddress(Request $req, AddressRepository $addressRepository): Response
    {
        if (!$this->basket->hasProducts() || !$this->getUser()) {
            !$this->getUser() ?
               $this->addFlash('alert', $this->translator->trans('accounting.register_warning'))
               : false;
            
            return $this->redirectToRoute(!$this->getUser() ? 'login' : 'basket' );
        }
    
        $addresses = $addressRepository->findBy(['user' => $this->getUser()]);
        
        if (!$addresses){
            $this->addFlash('alert', 'Veuillez renseigner une adresse de livraison avant de continuer');
            
            $form = $this->createForm(AddressType::class, new Address());
            $form->handleRequest($req);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $address = $form->getData();
                $address->setUser($this->getUser());
                $this->getDoctrine()->getManager()->persist($address);
            } else {
                
                return $this->render('front_office/shopping/checkout/address.html.twig', [
                   'address_form' => $form->createView()
                ]);
            }
        }
    
        $this->session->set('checkout/address-current-basket', true);
        $form = $this->createForm(SelectAddressType::class, null, ['addresses' => $addresses] );
        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set('checkout/address', true);
            $this->session->remove('checkout/current-checkout');
    
            return $this->redirectToRoute('checkoutSummary');
        }

        return $this->render('front_office/shopping/checkout/address.html.twig', [
            'address_choice_form' => $form->createView(),
        ]);
    }
    
    /**
     * @IsGranted("ROLE_USER")
     * @Route("checkout/shipping", name="checkoutShipping")
     */
    public function shipping()//Request $req)
    {
/*        if (!$this->session->get('checkout/address')) {
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
        ]);*/
    }
    
    /**
     * @Route("checkout/summary", name="checkoutSummary")
     */
    public function summary()
    {
        if (!$this->session->get('checkout/address')) {
            return $this->redirectToRoute('checkoutAddress');
        }
        
        $this->session->set('checkout/summary', true);
    
        if ($this->basket->hasProducts()) {
            $products = $this->basket->getProducts();
        }
    
        $productsWithQuantity = [];
        $totalPrice  = 0;
    
        foreach ($products as $product) {
            $qte =$this->basket->getQuantity($product);
            $totalPrice += $this->basket->totalPrice([$product]) * $qte;
        
            $productsWithQuantity[] = [
               'product' => $product,
               'quantity' => $qte,
               'thisPrice' => $this->basket->totalPrice([$product]) * $qte
            ];
        }
    
        $this->session->remove('checkout/address');
        //$vatPrice = $this->basket->vatPrice($this->basket->grandTotal());
        //$grandTotal = $this->basket->grandTotal();
        
        return $this->render('front_office/shopping/checkout/summary.html.twig', [
            'products' => $productsWithQuantity,
            'totalPrice' => $totalPrice
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
        
        $this->session->remove('checkout/summary');
        $this->session->set('checkout/payment', true);

        return $this->render('front_office/shopping/checkout/payment.html.twig', [
            'total_price' => $this->basket->grandTotal(),
        ]);
    }
}
