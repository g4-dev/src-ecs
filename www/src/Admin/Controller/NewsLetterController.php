<?php


namespace Admin\Controller;

use Admin\Entity\Letter;
use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController;
use Core\Entity\User;
use Core\Generics\Entity\Entity;
use Core\Service\MailerService;

class NewsLetterController extends EasyAdminController
{
    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function persistLetterEntity($entity)
    {
           $user = $this->getDoctrine()->getRepository(User::class)->findBy(['newsLetter' => true]);

        foreach ($user as $users) {
            $this->mailer->twigSendPurchase(
                'EcoService NewsLetter',
                $users,
                'mail/newsLetter.html.twig',
                [
                  'Title' => $entity->getName(),
                  'Content' => $entity->getBody(),
                ]
            );
        }
            
           $entity->setAdmin($this->getUser());
           parent::persistEntity($entity);
    }
}
