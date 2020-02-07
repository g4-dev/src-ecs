<?php

namespace Core\Service;

use Core\Entity\User;
use Core\Entity\Admin;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;


class MailerService
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $emailFrom;

    /**
     * @var
     */
    protected $emailName;

    /**
     * @var AdminService
     */
    protected $adminService;

    public function __construct(LoggerInterface $logger,
                                MailerInterface $mailer,
                                \Twig\Environment $twig,
                                string $emailFrom,
                                string $emailName,
                                AdminService $adminService
    )
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->emailFrom = $emailFrom;
        $this->emailName = $emailName;
        $this->adminService = $adminService;
    }

    public function createMessage($subject, $body): Email
    {
        $message = new Email();
        
        $message->subject($subject);
        $message->html($body);
        $message->from(new Address($this->emailFrom, $this->emailName));
        return $message;
    }

    public function createTwigMessage($subject, $template, $context = []): Email
    {
        return $this->createMessage($subject, $this->twig->render($template, $context));
    }

    public function send(Email $message, $to = null)
    {
        if (isset($to)) {
            $message->to($to);
        }
        return $this->mailer->send($message);
    }

    public function broadcastToAdmins(Email $message)
    {
        $list = $this->adminService->listAdmins();
        /** @var Admin $admin */
        foreach ($list->getItems() as $admin) {
            $message->to($admin->getEmail());
            $this->send($message);
        }
    }

    public function createEventMessage($subject, $payload): Email
    {
        return $this->createTwigMessage($subject,'mail/event.html.twig', [
            'subject' => $subject,
            'payload' => $payload
        ]);
    }

    public function twigSend(string $subject, User $user, string $template)
    {
        try{
            $message = $this->createTwigMessage($subject, $template);
            $this->send($message, $user->getEmail());
        } catch (TransportException | \Exception $e){
            return $e->getMessage();
        }
        
        return 'Mail successfully sent';
    }
}
