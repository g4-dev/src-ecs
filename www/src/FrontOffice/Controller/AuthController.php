<?php

namespace FrontOffice\Controller;

use FrontOffice\Form\LoginForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    protected $authUtils;

    public function __construct(AuthenticationUtils $authUtils)
    {
        $this->authUtils = $authUtils;
    }

    /**
     * @Route("/login", name="fo_login")
     */
    public function login()
    {
        $form = $this->createForm(LoginForm::class, [
            '_username' => $this->authUtils->getLastUsername()
        ]);
        return $this->render('front_office/accounting/login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="fo_logout")
     */
    public function logout()
    {
        throw new \RuntimeException("Logout? You shouldn't be able to get here...");
    }
}
