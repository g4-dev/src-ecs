<?php

namespace Admin\Controller\Accounting;

use Admin\Form\Accounting\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    protected $authUtils;

    public function __construct(AuthenticationUtils $authUtils)
    {
        $this->authUtils = $authUtils;
    }

    /**
     * @Route("/login", name="admin_login")
     */
    public function login()
    {
        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('admin');
        }
        
        $form = $this->createForm(LoginForm::class, [
            '_username' => $this->authUtils->getLastUsername()
        ]);
        
        return $this->render('@fo/accounting/admin-login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logout()
    {
        throw new \RuntimeException("Logout? You shouldn't be able to get here...");
    }
}
