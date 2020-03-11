<?php

namespace Core\Service;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api as PayPalApi;
use PayPal\Exception;

class PaymentService
{
    const CLIENT_ID = 'AddGmlqTUQrRQKC-BmA70jqEaJM7HDgkE22w22QUrDZwQTAXSupw6jtpqHFRiBsd8JoIAxjYqtaxyYDn';
    const CLIENT_SECRET = 'ECGl_NQUdmwneNJq9hYEntmE4XZ_5nkBg4vOVrTzKEyyRwsUuM_DPBVQ5FUvn4zmLcN3COXsLU74S0r4';

    public function __construct()
    {
        //$this->
    }

    public function payment()
    {

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                self::CLIENT_ID,     // ClientID
                self::CLIENT_SECRET      // ClientSecret
            )
        );

        $payer = new PayPalApi\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new PayPalApi\Amount();
        $amount->setTotal('1.00');
        $amount->setCurrency('USD');

        $transaction = new PayPalApi\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new PayPalApi\RedirectUrls();
        $redirectUrls->setReturnUrl("http://ecoservice.com")
            ->setCancelUrl("http://ecoservice.com");

        $payment = new PayPalApi\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        // 4. Make a Create Call and print the values
        try {
            $payment->create($apiContext);
            return $payment;

            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            //echo $ex->getData();
            return $ex->getMessage();
        }
    }


}
