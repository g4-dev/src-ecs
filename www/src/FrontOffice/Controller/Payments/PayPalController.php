<?php

namespace FrontOffice\Controller\Payments;

use Core\Service\MailerService;
use Core\Service\PurchaseFactoryService;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Entity\Basket;
use FrontOffice\Payments\PaypalFactory;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PayPalController extends AbstractController
{
    private $basket;
    private $apiContext;
    private $session;
    const CLIENT_ID = 'AddGmlqTUQrRQKC-BmA70jqEaJM7HDgkE22w22QUrDZwQTAXSupw6jtpqHFRiBsd8JoIAxjYqtaxyYDn';
    const CLIENT_SECRET = 'ECGl_NQUdmwneNJq9hYEntmE4XZ_5nkBg4vOVrTzKEyyRwsUuM_DPBVQ5FUvn4zmLcN3COXsLU74S0r4';
    
    public function __construct(
       EntityManagerInterface $objectManager,
       SessionInterface $session
    ) {
        $this->basket = new Basket($objectManager);
        // TODO: Load the config in a cleaner way
        $this->apiContext = new ApiContext(
           new OAuthTokenCredential(
              self::CLIENT_ID,     // ClientID
              self::CLIENT_SECRET      // ClientSecret
           )
        );
        
        $this->session = $session;
    }
    
    /**
     * Generates the payment and redirects to the paypal checkout page
     *
     * @Route("checkout/paypal", name="checkoutPaypal")
     * @param Request $req
     * @return Response
     */
    public function paypalCheckout(Request $req)
    {
        if (!$this->session->get('checkout/payment')) {
            return $this->redirectToRoute('basket');
        }
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        
        $baseUrl = $req->getScheme().'://'.$req->getHttpHost();
        
        $redirectUrls = (new RedirectUrls())
           ->setReturnUrl($baseUrl.$this->generateUrl('paypal_payment'))
           ->setCancelUrl($baseUrl.$this->generateUrl('basket'));
        
        $payment = (new Payment())
           ->setPayer((new Payer())->setPaymentMethod('paypal'))
           ->setIntent('sale')
           ->addTransaction(PaypalFactory::create($this->basket))
           ->setRedirectUrls($redirectUrls);
        
        try {
            $payment->create($this->apiContext);
        } catch (\Exception $e) {
            return new Response('Payement impossible');
        }
        
        $this->session->set('checkout/paypal-checkout', true);
        
        return $this->redirect($payment->getApprovalLink());
    }
    
    /**
     * Actually executes the payment after the customer was redirected back from paypal
     *
     * @Route("checkout/paypal-payment",name="checkoutPayment")
     * @param Request $req
     * @param MailerService $mailer
     * @param PurchasefactoryService $orderFactory
     * @return Response
     */
    public function paypalPayment(
       Request $req,
       MailerService $mailer,
       PurchaseFactoryService $purchaseFactory
    ) {
        if (!$this->session->get('checkout/paypal-checkout')) {
            return $this->redirectToRoute('basket');
        }
        
        $payment = Payment::get($req->get('paymentId'), $this->apiContext);
        
        $execution = (new PaymentExecution())
           ->setPayerId($req->get('PayerID'))
           ->setTransactions($payment->getTransactions());
        
        try {
            $payment->execute($execution, $this->apiContext);
        } catch (\Exception $e) {
            return new Response('Paiement impossible');
        }
        
        $user = $this->getUser();
        
        $purchase = $purchaseFactory->create($this->basket, $user, 'paypal');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($purchase);
        $em->flush();
        
        $mailer->twigSend(
           'Purchase Success',
           $user,
           'mail/order_confirmation.html.twig'
        );
        
        $this->basket->clear();
        
        return $this->render(
           'front_office/shopping/order_confirmation.html.twig'
        );
    }
}
