<?php

namespace FrontOffice\Controller\Payments;

use Core\Helper\RandomIdGenerator;
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
use Symfony\Component\HttpFoundation\RedirectResponse;
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
           ->setReturnUrl($baseUrl.$this->generateUrl('paypalPayment'))
           ->setCancelUrl($baseUrl.$this->generateUrl('basket'));
        
        dump($redirectUrls);
        
        $payment = (new Payment())
           ->setPayer((new Payer())->setPaymentMethod('paypal'))
           ->setIntent('sale')
           ->addTransaction(PaypalFactory::create($this->basket))
           ->setRedirectUrls($redirectUrls);
        
        try {
            $payment->create($this->apiContext);
        } catch (\Exception $e) {
            $this->addFlash('success','Paiement Effectué, vérifier votre boîte mail');
            //return $this->redirectToRoute('homepage');
        }
        
        $this->session->set('checkout/paypal-checkout', true);
        
        return $this->redirect($this->generateUrl('paypalPayment'));//$payment->getApprovalLink());
    }
    
    /**
     * Actually executes the payment after the customer was redirected back from paypal
     *
     * @Route("checkout/paypal-payment",name="paypalPayment")
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
        
        /*$payment = Payment::get(RandomIdGenerator::generate(), $this->apiContext) ?? true;//$req->get('paymentId')
        
        $execution = (new PaymentExecution())
           ->setPayerId($req->get('PayerID'))
           ->setTransactions($payment->getTransactions());
        
        try {
            $payment->execute($execution, $this->apiContext);
        } catch (\Exception $e) {
            //sreturn new Response('Paiement impossible');
        }*/
        
        $user = $this->getUser();
        
        $purchase = $purchaseFactory->create($this->basket, $user, 'paypal');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($purchase);
        $em->flush();
        
        try {
        // TODO design command
        $mailer->twigSend(
           'Purchase Success',
           $user,
           '@fo/mail/purchase_confirmation.html.twig'
        );
        } catch (\Exception $e) {
            $this->createNotFoundException();
        }
        
        $this->basket->clear();
        
        return $this->render(
           'front_office/shopping/purchaseConfirmation.html.twig'
        );
    }
}
