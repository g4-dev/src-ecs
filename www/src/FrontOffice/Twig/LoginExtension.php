<?php

namespace FrontOffice\Twig;

use Admin\Repository\NavRepository;
use Core\Generics\Collection\Collection;
use FrontOffice\Form\Accounting\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LoginExtension extends AbstractExtension
{
    protected $authUtils;
    protected $factory;
    protected $twig;
    protected $navRepo;
    
    public function __construct(
       Environment $twig, AuthenticationUtils $authUtils,
       FormFactoryInterface $factory,
       NavRepository $navRepository
    ) {
        $this->authUtils = $authUtils;
        $this->factory = $factory;
        $this->twig = $twig;
        $this->navRepo = $navRepository;
    }
    
    public function getFunctions()
    {
        return [
           new TwigFunction('popLogin', [$this, 'popLogin']),
           new TwigFunction('navWalker', [$this, 'navWalker']),
        ];
    }
    
    public function popLogin(string $target) {
        $form = $this->factory->create(LoginForm::class, [
           '_username' => $this->authUtils->getLastUsername()
        ]);
        
        return $this->twig->render('front_office/partials/embed-login.html.twig', [
           'form' => $form->createView(),
           'error' => $this->authUtils->getLastAuthenticationError(),
           'targetPath' => $target
        ]);
    }
    
    public function navWalker()
    {
        $collectionMenu = $this->navRepo->findby([], ['position' => 'ASC']);
        $collec = [];
        # order with bootstrap
        
        foreach ($collectionMenu as $nav) {
            dump($nav);
            //$collec[] = $nav
            //dump($collec);
        }
        
        dump($this->navRepo->findAll());
        return $this->navRepo->findAll();
    }
}