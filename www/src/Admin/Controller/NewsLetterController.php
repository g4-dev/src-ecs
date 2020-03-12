<?php


namespace Admin\Controller;

use Admin\Entity\NewsLetter;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use Core\Entity\User;
use Core\Service\MailerService;

class NewsLetterController extends EasyAdminController
{
    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

     function createNewNewsLetterAction(NewsLetter $newsLetter)
    {
            $title = $newsLetter->getName();
            $content = $newsLetter->getBody();

            $NewLetter = true;
            $user = $this->getDoctrine()->getRepository(User::class)->findBy($NewLetter);
            dd($user);
            foreach ($user as $users) {
                $this->twigSendPurchase(
                    'EcoService NewsLetter',
                    $users,
                    'mail/newsLetter.html.twig',
                    [
                        'Title' => $title,
                        'Content' => $content,
                    ]
                );
            }
            $this->em->persist($newsLetter);
            $this->em->flush();
            parent::initialise();
    }
}