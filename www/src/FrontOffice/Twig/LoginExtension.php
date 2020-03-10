<?php

namespace FrontOffice\Twig;

use FrontOffice\Form\Accounting\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LoginExtension extends AbstractExtension
{
    protected $authUtils;
    protected $factory;
    protected $twig;
    
    public function __construct(Environment $twig, AuthenticationUtils $authUtils, FormFactoryInterface $factory)
    {
        $this->authUtils = $authUtils;
        $this->factory = $factory;
        $this->twig = $twig;
    }
    
    public function getFunctions()
    {
        return [
           new TwigFunction('popLogin', [$this, 'embedLogin']),
        ];
    }
    
    public function embedLogin(string $target) {
        $form = $this->factory->create(LoginForm::class, [
           '_username' => $this->authUtils->getLastUsername()
        ]);
        
        dump($target);
        
        return $this->twig->render('front_office/partials/embed-login.html.twig', [
           'form' => $form->createView(),
           'error' => $this->authUtils->getLastAuthenticationError(),
           'targetPath' => $target
        ]);
    }
}