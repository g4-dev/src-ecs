<?php


namespace Admin\Controller;


use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use Core\Entity\User;
use Core\Service\MailerService;

class NewsLetterController extends EasyAdminController
{
    public function newNewsLetterAction(MailerService $mailer)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy();
        try {
        $mailer->twigSendPurchase(
            'Purchase Success',
            $user,
            'mail/order_confirmation.html.twig',
            );
    } catch (\Exception $e) {
        $this->createNotFoundException();
        }
    }
}