<?php

namespace FrontOffice\Controller;

use Core\Service\UserService;
use FrontOffice\Form\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/sign-up", name="fo_registration")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(RegistrationForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->register($form->getData());
            return $this->redirectToRoute('fo_homepage');
        }

        return $this->render('front_office/accounting/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sign-up/activate/{uniqueId}/{token}",
     *     name="fo_registration_activate",
     *     requirements={"uniqueId": "[a-zA-Z0-9]{10}", "token": "[a-zA-Z0-9]{32}"})
     */
    public function activate($uniqueId, $token)
    {
        $user = $this->userService->fetchByUniqueId($uniqueId);
        if ($user->getToken() == $token) {
            $this->userService->activate($user);
            return $this->redirectToRoute('fo_homepage');
        }
        return new Response('error');
    }
}
