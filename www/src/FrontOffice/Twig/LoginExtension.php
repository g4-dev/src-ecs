<?php

namespace FrontOffice\Twig;

use Admin\Entity\CmsCategory;
use Admin\Entity\CmsPage;
use Admin\Entity\Diy;
use Admin\Entity\Product;
use Admin\Entity\ProductCategory;
use Admin\Repository\NavRepository;
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
        $collectionMenu = $this->navRepo->findby([], ['position' => 'ASC']) ?? [];
        
        if (!$collectionMenu) {
            return [
               'name' => 'not configured menu',
               'title' => 'configure your menu in /admin',
               'route' => 'homepage',
               'routeParams' => null
            ];
        }
        
        $navWalked = [];
        
        foreach ($collectionMenu as $nav) {
            $p = $nav->getPage();
            $route = '';
            
            if ($p instanceof ProductCategory) {
                $route = 'productCategoryList';
            } else if ($p instanceof CmsCategory) {
                $route = 'cmsCategoryList';
            } else if ( $p instanceof CmsPage ) {
                $route = 'cmsShow';
            } else if ($p instanceof Diy) {
                $route = 'diyShow';
            } else if ($p instanceof Product) {
                $route = 'productShow';
            } else {
                $route = 'homepage';
            }
    
            $routeParams = [
               'slug' => $p->getSlug() ?? null
            ];
            
            $navWalked[] = [
               'name' => $nav->getName(),
               'title' => $p->getName(),
               'route' => $route,
               'routeParams' => $routeParams
            ];
            
            
        }
        dump($navWalked);
        return $navWalked;
    }
}