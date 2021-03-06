<?php

namespace FrontOffice\Controller\Accounting;

use FrontOffice\Form\Accounting\LoginForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends \FrontOffice\Controller\AbstractController
{
    protected $authUtils;

    public function __construct(AuthenticationUtils $authUtils)
    {
        $this->authUtils = $authUtils;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        $form = $this->createForm(
            LoginForm::class, [
                '_username' => $this->authUtils->getLastUsername()
            ]
        );
        
        if ($this->getUser()) {
            $redirectUrl = $request->request->get('login_form')['_target_path'] ?? null;
            
            if ($redirectUrl) {
                return $this->redirect($redirectUrl);
            }
            
            return $this->redirectToRoute("homepage");
        }
        
        return $this->render(
            'front_office/accounting/login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authUtils->getLastAuthenticationError()
            ]
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \RuntimeException("Logout? You shouldn't be able to get here...");
    }
}
