<?php

namespace Admin\Security;

use Admin\Form\Accounting\LoginForm;
use Core\Entity\Admin;
use Core\Service\AdminService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormGuard extends AbstractFormLoginAuthenticator
{
    const PROVIDER_KEY = 'admin';
    const LOGIN_URI = '/admin/login';
    
    use TargetPathTrait;
    /**
     * @var AdminService
     */
    private $adminService;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
            AdminService $adminService,
            FormFactoryInterface $formFactory,
            RouterInterface $router,
            SessionInterface $session)
    {
        $this->adminService = $adminService;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->session = $session;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'admin_login' && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return $this->formFactory->create(LoginForm::class)
            ->handleRequest($request)
            ->getData();
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->adminService->findByEmail($credentials['_username']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $user->isActive() && $this->adminService->validatePassword($user, $credentials['_password']);
    }

    public function getLoginUrl()
    {
        return $this->router->generate('admin_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /** @var Admin $user */
        $admin = $token->getUser();
        if (!($admin instanceof Admin)) {
            throw new \RuntimeException("That's unexpected");
        }
        $admin->setLastLoginAt(new \DateTime());
        $admin->setLastLoginIp($request->getClientIp());
        if ($request->headers->has('User-Agent')) {
            $admin->setLastUserAgent($request->headers->get('User-Agent'));
        }
        $this->adminService->save($admin);
        $response = $this->router->generate('easyadmin');
        // TODO: Use this code to save last page
        /*
        if (true === strpos($this->getTargetPath($this->session,self::PROVIDER_KEY), self::LOGIN_URI)) {
            $response = $this->getTargetPath($this->session,self::PROVIDER_KEY);
        }*/
        
        return new RedirectResponse($response, 301);
    }
}
